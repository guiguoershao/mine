package routes

import (
	"github.com/gin-gonic/gin"
	"net/http"
)

type Route struct {
	*gin.Engine
}

func (route Route) Dispatch() {
	route.baseRoute().
		setApiRoute().
		setWebRoute()
}

func (route Route) baseRoute() Route {
	error404 := func(ctx *gin.Context) {
		ctx.JSON(http.StatusNotFound, gin.H{
			"code": -1,
			"msg":  "访问的路由不存在",
		})
	}
	route.NoRoute(error404)
	route.NoMethod(error404)
	return route
}

// api 路由
func (route Route) setApiRoute() Route {
	api := route.Group("/api")
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

	return route
}

// web 路由
func (route Route) setWebRoute() Route {
	web := route.Group("/")
	web.GET("/web", func(ctx *gin.Context) {
		ctx.JSON(http.StatusOK, gin.H{
			"code": 0,
			"msg":  ctx.Request.RequestURI,
		})
	})
	return route
}
