package framework

import (
	"fmt"
	"gin-mine/configs"
	"gin-mine/routes"
	"github.com/gin-gonic/gin"
	"github.com/spf13/viper"
)

type Bootstrap struct {
	ginInstance *gin.Engine
	confPath    string
	confName    string
	confType    string
}

var Instance *Bootstrap

func NewBootstrap(ginInstance *gin.Engine, config map[string]string) *Bootstrap {
	Instance := &Bootstrap{
		ginInstance: ginInstance,
		confPath:    config["confPath"],
		confName:    config["confName"],
		confType:    config["confType"],
	}

	return Instance
}

func (bs *Bootstrap) Instance() *Bootstrap {
	return Instance
}

func (bs *Bootstrap) StartUpRouter() *Bootstrap {
	r := routes.Route{bs.ginInstance}

	// 加载路由
	r.Dispatch()

	return bs
}

func (bs *Bootstrap) StartUpConfig() *Bootstrap {
	// 加载配置
	viper := viper.New()
	configInstance := configs.NewConfig(viper)
	//	配置并读取至内存中
	configInstance.SetConf(bs.confPath, bs.confName, bs.confType).ReadInConfig()
	return bs
}

func Redis() {

}

//	启动
func (bs *Bootstrap) Run() {
	//console.Print("操作:启动服务 模式:%s 端口:%s", Config.App.Mode, Config.App.Addr)

	addr := fmt.Sprintf(":%v", configs.GetInstance().GetString("http.port"))
	bs.ginInstance.Run(addr)
}
