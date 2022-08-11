package controller

import (
	"errors"
	"fmt"
	"github.com/gin-gonic/gin"
	"github.com/go-playground/validator/v10"
)

type Controller struct {
	Jump Jump
}

//	参数过滤器
func (ctrl *Controller) Filter(ctx *gin.Context, filterStruct interface{}) error {
	err := ctx.ShouldBind(filterStruct)
	if err != nil {
		errorMap, ok := err.(validator.ValidationErrors)
		if !ok {
			return err
		}
		for _, v := range errorMap {
			return errors.New(fmt.Sprintf("参数:%s,数据类型：%s,验证规则:%s", v.Field(), v.Kind(), v.Tag()+":"+v.Param()))
		}
	}

	return nil
}

func (ctrl *Controller) Error404(ctx *gin.Context) {
	//ctx.JSON(http.StatusNotFound, )
}
