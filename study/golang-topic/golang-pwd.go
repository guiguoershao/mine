package main

import (
	"fmt"
	"golang.org/x/crypto/bcrypt"
)

// 生成密码
func GenPwd(pwd string) ([]byte, error) {
	hash, err := bcrypt.GenerateFromPassword([]byte(pwd), bcrypt.DefaultCost)
	return hash, err
}

// 比对密码
func ComparePwd(pwd1 string, pwd2 string) bool {
	// 加密的密码（密文）， 对比的密码（明文）
	err := bcrypt.CompareHashAndPassword([]byte(pwd1), []byte(pwd2))
	if err != nil {
		return false
	}
	return true
}

func main() {
	pwd := "123456"

	hashPwd, _ := GenPwd(pwd)

	pwd2 := "123456"

	b := ComparePwd(string(hashPwd), pwd2)

	fmt.Printf("pwd1: %v, hasspwd: %v, pwd2: %v, res: %v\n", pwd, string(hashPwd), pwd2, b)
}
