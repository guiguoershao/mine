package sys_enum

const (
	StatusOk              = 0
	StatusParamIsError    = 20000 //参数级
	StatusDataIsNotExists = 30000 //业务级
	StatusDataOpError     = 39999 //业务级
	StatusAuthForbidden   = 40001 //权限
	StatusNotFound        = 49999 //系统级
	StatusUnknownError    = 50000 //系统级
	StatusUnknownResponse = 59999 //未定义接口响应
)

var statusText = map[int]string{
	StatusOk:              "ok",
	StatusParamIsError:    "参数错误",
	StatusDataIsNotExists: "数据不存在",
	StatusDataOpError:     "操作失败！请稍候重试",
	StatusAuthForbidden:   "未授权！",
	StatusUnknownError:    "未知错误！请稍候重试",
	StatusNotFound:        "未知请求！",
	StatusUnknownResponse: "无正确响应",
}

func StatusText(code int) string {
	text, ok := statusText[code]
	if ok {
		return text
	}
	return statusText[StatusUnknownError]
}
