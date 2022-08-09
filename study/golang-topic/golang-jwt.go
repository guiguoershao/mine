package main

import (
	"errors"
	"fmt"
	"github.com/dgrijalva/jwt-go"
	"time"
)

type MyClaims struct {
	Username string `json:"username"`
	Password string `json:"password"`
	jwt.StandardClaims
}

var MySecret = []byte("secret")

func GenToken(username string, password string) (string, error) {
	// 创建一个我们自己的声明
	c := MyClaims{
		Username: username,
		Password: password,
		StandardClaims: jwt.StandardClaims{
			ExpiresAt: time.Now().Add(time.Second * 2).Unix(), // 过期时间
			Issuer:    "huohuo",                               // 签发人
		},
	}
	// 使用指定的签名方法创建签名对象
	token := jwt.NewWithClaims(jwt.SigningMethodHS256, c)
	// 使用指定的secret签名并获得完整的编码后的字符串token
	// 注意这个地方一定要是字节切片 不能是字符串
	return token.SignedString(MySecret)
}

func ParseToken(tokenString string) (*MyClaims, error) {
	// 解析token
	token, err := jwt.ParseWithClaims(tokenString, &MyClaims{}, func(token *jwt.Token) (interface{}, error) {
		return MySecret, nil
	})

	if err != nil {
		return nil, err
	}

	claims, ok := token.Claims.(*MyClaims)
	// 校验token
	if ok && token.Valid {
		return claims, nil
	}
	return nil, errors.New("invalid token")
}

//noinspection ALL
func main() {
	s, err := GenToken("fengyan", "6542815")
	if err != nil {
		fmt.Printf("err : %v\n", err)
		return
	}
	fmt.Printf("s : %v\n", s)

	//
	time.Sleep(time.Second * 3)

	mc, err2 := ParseToken(s)

	if err2 != nil {
		//panic(err2)
		fmt.Printf("err2 : %v\n", err2)
		return
	}

	fmt.Printf("mc.username: %v, mc.password: %v\n", mc.Username, mc.Password)
}
