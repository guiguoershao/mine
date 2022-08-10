package framework

import (
	"fmt"
	"gin-mine/configs"
	"gin-mine/framework/core"
	"gin-mine/routes"
	"github.com/gin-gonic/gin"
	"github.com/go-redis/redis/v9"
	"github.com/spf13/viper"
	"gorm.io/gorm"
)

type Bootstrap struct {
	ginInstance *gin.Engine
	confPath    string
	confName    string
	confType    string

	redisInstance *redis.Client
	ormInstance   *gorm.DB
}

var instance Bootstrap

func NewBootstrap(ginInstance *gin.Engine, config map[string]string) *Bootstrap {
	instance := &Bootstrap{
		ginInstance: ginInstance,
		confPath:    config["confPath"],
		confName:    config["confName"],
		confType:    config["confType"],
	}

	return instance
}

func Core() Bootstrap {
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
	//console.Print("操作:启动服务 模式:%s 端口:%s", Config.App.Mode, Config.App.Addr)

	addr := fmt.Sprintf(":%v", configs.GetInstance().GetString("http.port"))
	bs.ginInstance.Run(addr)
}

//	Redis 客户端
func (bs Bootstrap) Redis() *redis.Client {
	if bs.redisInstance == nil {
		bs.redisInstance = core.RedisInstance()
	}
	fmt.Printf("%v", bs.redisInstance)
	return bs.redisInstance
}

//	Gorm 实例
func (bs Bootstrap) Orm() *gorm.DB {
	if bs.ormInstance == nil {
		bs.ormInstance = core.ORMInstance()
	}
	return bs.ormInstance
}
