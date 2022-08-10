package main

import (
	"gin-mine/routes"
	"github.com/gin-gonic/gin"
	"net/http"
)

func main() {
	ginInstance := gin.Default()

	r := routes.Route{ginInstance}

	r.GET("/", func(ctx *gin.Context) {
		ctx.JSON(http.StatusOK, gin.H{
			"code": 0,
			"msg":  "ok",
		})
	})
	r.Dispatch()
	r.Run(":8001")
}
