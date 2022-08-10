package main

import (
	"gin-mine/framework"
	"github.com/gin-gonic/gin"
)

func main() {
	ginInstance := gin.Default()

	config := make(map[string]string)
	config["confPath"] = "."
	config["confName"] = "config"
	config["confType"] = "ini"
	bootstrap := framework.NewBootstrap(ginInstance, config)

	//	启动
	bootstrap.
		StartUpRouter().
		StartUpConfig().
		Run()
}
