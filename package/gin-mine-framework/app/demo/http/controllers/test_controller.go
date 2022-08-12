package controllers

import (
	"gin-mine/framework/controller"
	"gin-mine/framework/sys_utils/mcrypt"
	"github.com/gin-gonic/gin"
)

type TestController struct {
	controller.Controller
}

func (ctrl TestController) T1(ctx *gin.Context) {
	/*framework.Logger().Info("测试日志")
	framework.Redis().Set(ctx, "key", "golang-teck-stack.com", 0)

	val, _ := framework.Redis().Get(ctx, "key").Result()
	data := make(map[string]string)
	data["key"] = val*/

	data := make(map[string]string)
	appSecret := "IgkibX71IEf382PT"
	encryptStr := "param_1=xxx&param_2=xxx&ak=xxx&ts=1111111111"
	aes := &mcrypt.Aes{}
	sn, _ := aes.Encrypt(encryptStr, []byte(appSecret), appSecret)
	ns, _ := aes.Decrypt(sn, []byte(appSecret), appSecret)
	data["jiami"] = sn
	data["jiemi"] = ns

	ctrl.Jump.Success(ctx, "asdfasdf", data)
}
