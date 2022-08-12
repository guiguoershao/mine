package sys_utils

import (
	"fmt"
	"gin-mine/framework/sys_enum"
)

type ResponseBean struct {
	Code int         `json:"code"`
	Msg  string      `json:"msg"`
	Data interface{} `json:"data"`
}

// 响应实例
func RespInstance() *ResponseBean {
	return &ResponseBean{
		Code: sys_enum.StatusUnknownError,
		Msg:  sys_enum.StatusText(sys_enum.StatusUnknownError),
		Data: map[string]interface{}{},
	}
}

//	设置 状态码
func (response *ResponseBean) SetCode(code int) *ResponseBean {
	response.Code = code
	return response
}

//	设置信息
func (response *ResponseBean) SetMsg(msg string) *ResponseBean {
	response.Msg = msg
	return response
}

//	设置响应Data
func (response *ResponseBean) SetData(params ...interface{}) *ResponseBean {
	response.Data = params
	return response
}

func (response *ResponseBean) Response(code int, params ...interface{}) *ResponseBean {
	response.Code = code
	i := 0
	isSetMsg := false
	if paramSize := len(params); paramSize > 0 {
		for index := range params {
			param := params[index]
			paramType := fmt.Sprintf("%T", param)
			//console.Print("paramType: %v,  %v, %v", index, paramType, param)
			if paramType == "string" {
				response.Msg = param.(string)
				isSetMsg = true
			} else {
				response.Data = param
			}
			if i > 0 {
				break
			} else {
				if isSetMsg {
					response.Data = param
				}
			}
			i++
		}
	}
	if !isSetMsg {
		response.Msg = sys_enum.StatusText(code)
	}
	return response
}

/*func (response *ResponseBean) AddData(key string, params interface{}) *ResponseBean {
	if response.Data == nil {
		response.Data = make(map[string]interface{})
	}
	response.Data[key] = params
	return response
}*/

type ResponseStringBean struct {
	Code    int    `json:"code"`
	Content string `json:"content"`
}
