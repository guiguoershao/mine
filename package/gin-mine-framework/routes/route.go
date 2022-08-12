package routes

import (
	demo_controllers "gin-mine/app/demo/http/controllers"
	"github.com/gin-gonic/gin"
	"net/http"
)

func Dispatch(r *gin.Engine) {
	baseRoute(r)
	setApiRoute(r)
	setWebRoute(r)
}

func baseRoute(r *gin.Engine) {
	error404 := func(ctx *gin.Context) {
		ctx.JSON(http.StatusNotFound, gin.H{
			"code": -1,
			"msg":  "访问的路由不存在",
		})
	}
	r.NoRoute(error404)
	r.NoMethod(error404)
}

// api 路由
func setApiRoute(r *gin.Engine) {
	api := r.Group("/api")
	api.GET("/t1", func(ctx *gin.Context) {
		ctx.JSON(http.StatusOK, gin.H{
			"code": 0,
			"msg":  ctx.Request.RequestURI,
		})
	})

	apiGroup := api.Group("/basic")
	apiGroup.GET("/test", func(ctx *gin.Context) {
		ctx.JSON(http.StatusOK, gin.H{
			"code": 0,
			"msg":  ctx.Request.RequestURI,
		})
	})
}

// web 路由
func setWebRoute(r *gin.Engine) {
	web := r.Group("/")
	web.GET("/web", func(ctx *gin.Context) {
		ctx.JSON(http.StatusOK, gin.H{
			"code": 0,
			"msg":  ctx.Request.RequestURI,
		})
	})

	TestController := &demo_controllers.TestController{}
	web.GET("/test", TestController.T1)
}
