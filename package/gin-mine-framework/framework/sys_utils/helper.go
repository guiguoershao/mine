package sys_utils

import (
	"crypto/md5"
	"encoding/hex"
)

//	md5 加密
func MD5(str string) string {
	s := md5.New()
	s.Write([]byte(str))
	return hex.EncodeToString(s.Sum(nil))
}
