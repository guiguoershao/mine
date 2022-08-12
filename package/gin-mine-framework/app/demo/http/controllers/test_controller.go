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
	framework.Redis().Set(ctx, "key", "golang-teck-stack.com", 0)

	val, _ := framework.Redis().Get(ctx, "key").Result()

	data := make(map[string]string)
	data["key"] = val

	ctrl.Jump.Success(ctx, "asdfasdf", data)
}
