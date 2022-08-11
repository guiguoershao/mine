package controller

import (
	"gin-mine/framework/console"
	"gin-mine/framework/sys_enum"
	"gin-mine/framework/sys_utils"
	"github.com/gin-gonic/gin"
	"net/http"
)

type Jump struct {
}

func (j Jump) Ping(ctx *gin.Context) {
	j.Success(ctx, "pong")
}

// 响应输出
func (j Jump) Response(ctx *gin.Context, code int, dataOrMsgParams ...interface{}) {
	resp := sys_utils.RespInstance()
	resp.Response(code, dataOrMsgParams...)
	console.Print("resp.msg: %v", resp.Msg)

	//ctx.Set("TagResponseJsonBean", resp)
	//ctx.Abort()

	ctx.JSON(http.StatusOK, resp)
}

func (j Jump) Success(ctx *gin.Context, dataOrMsgParams ...interface{}) {
	j.Response(ctx, sys_enum.StatusOk, dataOrMsgParams...)
}

func (j Jump) Error(ctx *gin.Context, code int, dataOrMsgParams ...interface{}) {
	j.Response(ctx, code, dataOrMsgParams...)
}
