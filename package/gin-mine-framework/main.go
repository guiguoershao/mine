package main

import (
	"gin-mine/configs"
	"gin-mine/routes"
	"github.com/gin-gonic/gin"
	"github.com/spf13/viper"
)

func main() {
	ginInstance := gin.Default()

	r := routes.Route{ginInstance}

	// 加载路由
	r.Dispatch()

	// 加载配置
	viper := viper.New()
	configInstance := configs.NewConfig(viper)

	//	配置并读取至内存中
	configInstance.SetConf("./configs", "config", "ini").ReadInConfig()

	httpPort := configInstance.GetString("http.port")

	r.Run(":" + httpPort)
}
