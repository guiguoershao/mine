package framework

import (
	"context"
	"errors"
	"fmt"
	"gin-mine/configs"
	"gin-mine/framework/console"
	"gin-mine/framework/sys_core"
	"gin-mine/routes"
	"github.com/gin-gonic/gin"
	"github.com/go-redis/redis/v9"
	"github.com/spf13/viper"
	"go.uber.org/zap"
	"gorm.io/gorm"
	"net/http"
	"os"
	"os/signal"
	"syscall"
	"time"
)

type Bootstrap struct {
	ginInstance *gin.Engine
	confPath    string
	confName    string
	confType    string

	redisInstance *redis.Client
	ormInstance   *gorm.DB
	logger        *zap.Logger
}

var instance *Bootstrap

func NewBootstrap(ginInstance *gin.Engine, config map[string]string) *Bootstrap {
	instance = &Bootstrap{
		ginInstance: ginInstance,
		confPath:    config["confPath"],
		confName:    config["confName"],
		confType:    config["confType"],
	}

	return instance
}

func Core() *Bootstrap {
	console.Print("bootstrap: %v\n", instance)
	return instance
}

//	加载路由
func (bs Bootstrap) LoadRouter() Bootstrap {
	r := routes.Route{bs.ginInstance}

	// 加载路由
	r.Dispatch()

	return bs
}

//	加载配置
func (bs Bootstrap) LoadConfig() Bootstrap {
	// 加载配置
	viper := viper.New()
	configInstance := configs.NewConfig(viper)
	//	配置并读取至内存中
	configInstance.SetConf(bs.confPath, bs.confName, bs.confType).ReadInConfig()
	return bs
}

//	启动
func (bs Bootstrap) Run() {
	config := configs.GetInstance().Entity

	console.Print("%v, %v\n ",
		configs.GetInstance().GetString("app.addr"), config.Mysql.DSN)

	console.Print("操作:启动服务 模式:%s 端口:%s", config.App.Mode, config.App.Addr)

	srv := &http.Server{
		Addr:    config.App.Addr,
		Handler: bs.ginInstance,
	}

	go func() {
		if err := srv.ListenAndServe(); err != nil && errors.Is(err, http.ErrServerClosed) {
			console.Print("操作:关闭服务")
		}
	}()

	quit := make(chan os.Signal, 1)
	signal.Notify(quit, syscall.SIGINT, syscall.SIGTERM)
	<-quit

	ctx, cancel := context.WithTimeout(context.Background(), 5*time.Second)
	defer cancel()

	if err := srv.Shutdown(ctx); err != nil {
		console.Fatal("操作:强制关闭服务,error:%s", err)
	}

	//addr := fmt.Sprintf(":%v", configs.GetInstance().GetString("http.port"))

	//bs.ginInstance.Run(addr)
}

//	Redis 客户端
func (bs Bootstrap) Redis() *redis.Client {
	if bs.redisInstance == nil {
		bs.redisInstance = sys_core.RedisInstance()
	}
	fmt.Printf("%v", bs.redisInstance)
	return bs.redisInstance
}

//	Gorm 实例
func (bs Bootstrap) Orm() *gorm.DB {
	if bs.ormInstance == nil {
		bs.ormInstance = sys_core.ORMInstance()
	}
	return bs.ormInstance
}

//	logger
func (bs Bootstrap) Logger() *zap.Logger {
	if bs.logger == nil {
		bs.logger = sys_core.Logger()
	}

	return bs.logger
}
