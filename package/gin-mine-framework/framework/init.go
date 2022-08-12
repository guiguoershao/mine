package framework

import (
	"context"
	"errors"
	"gin-mine/configs"
	"gin-mine/framework/console"
	"gin-mine/framework/sys_core"
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

var (
	loggerInstance *zap.Logger
	configInstance *configs.Config
)

var (
	redisInstance *redis.Client
	ormInstance   *gorm.DB
)

func init() {
	// 加载配置
	viper := viper.New()

	configInstance = configs.NewConfig(viper)

	//	配置并读取至内存中
	configInstance.SetConf().ReadInConfig()

	//	加载配置
	loggerInstance = sys_core.Logger()
}

//	启动
func Run(ginInstance *gin.Engine) {
	config := configInstance.Entity

	console.Print("%v, %v\n ",
		configInstance.GetString("app.addr"), config.Mysql.DSN)

	console.Print("操作:启动服务 模式:%s 端口:%s", config.App.Mode, config.App.Addr)

	srv := &http.Server{
		Addr:    config.App.Addr,
		Handler: ginInstance,
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

	//ginInstance.Run(addr)
}

//
func Config() *configs.Config {
	return configInstance
}

//	Redis 客户端
func Redis() *redis.Client {
	if redisInstance == nil {
		redisInstance = sys_core.RedisInstance()
	}
	return redisInstance
}

//	Gorm 实例
func Orm() *gorm.DB {
	if ormInstance == nil {
		ormInstance = sys_core.ORMInstance()
	}
	return ormInstance
}

//	logger
func Logger() *zap.Logger {
	return loggerInstance
}
