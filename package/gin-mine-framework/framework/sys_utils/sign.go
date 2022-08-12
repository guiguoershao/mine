package sys_utils

import (
	"fmt"
	"net/url"
	"sort"
)

// 	创建签名
func CreateSign(params url.Values, appSecret string) string {
	return MD5(appSecret + createEncryptStr(params) + appSecret)
}

//	创建签名
func createEncryptStr(params url.Values) string {
	var key []string
	var str = ""
	for k := range params {
		if k != "sn" && k != "debug" {
			key = append(key, k)
		}
	}
	//	按递增顺序对字符串片段排序
	sort.Strings(key)
	for i := 0; i < len(key); i++ {
		if i == 0 {
			str = fmt.Sprintf("%v=%v", key[i], params.Get(key[i]))
		} else {
			str += fmt.Sprint("&%v=%v", key[i], params.Get(key[i]))
		}
	}
	return str
}
