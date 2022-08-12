package main

import (
	"gin-mine/framework"
	"gin-mine/routes"
	"github.com/gin-gonic/gin"
)

func main() {
	ginInstance := gin.Default()

	routes.Dispatch(ginInstance)

	framework.Run(ginInstance)
}
