package controllers

import (
	"gin-mine/framework"
	"gin-mine/framework/controller"
	"github.com/gin-gonic/gin"
)

type TestController struct {
	controller.Controller
}

func (ctrl TestController) T1(ctx *gin.Context) {
	framework.Logger().Info("测试日志")
	ctrl.Jump.Ping(ctx)
}
