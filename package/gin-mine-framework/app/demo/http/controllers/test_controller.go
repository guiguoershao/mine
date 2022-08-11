package controllers

import (
	"gin-mine/framework/controller"
	"github.com/gin-gonic/gin"
)

type TestController struct {
	controller.Controller
}

func (ctrl TestController) T1(ctx *gin.Context) {
	ctrl.Jump.Ping(ctx)
}
