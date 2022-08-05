package main

import (
	"fmt"
	"github.com/gin-gonic/gin"
	"net/http"
)

// 模拟一些私人数据
var secrets = gin.H{
	"foo":    gin.H{"email": "foo@bar.com", "phone": "123456"},
	"austin": gin.H{"email": "austin@bar.com", "phone": "123123123"},
	"lena":   gin.H{"email": "lena@bar.com", "phone": "3122342343"},
}

func main() {
	r := gin.Default()

	// 路由组使用 gin.BasicAuth 中间件
	// gin.Accounts 是map[string]string 的一种快捷方式

	authorized := r.Group("/admin", gin.BasicAuth(gin.Accounts{
		"foo":    "bar",
		"austin": "1234",
		"lena":   "hello2",
		"manu":   "4321",
	}))

	// /admin/secrets 端点
	// 触发 "localhost:8080/admin/secrets"
	authorized.GET("/secrets", func(c *gin.Context) {
		// 获取用户， 它是由basicAuth中间件设置的
		user := c.MustGet(gin.AuthUserKey).(string)
		fmt.Println(user)

		if secret, ok := secrets[user]; ok {
			c.JSON(http.StatusOK, gin.H{"user": user, "secret": secret})
		} else {
			c.JSON(http.StatusOK, gin.H{"user": user, "secret": "NO SECRET :("})
		}
	})

	r.Run(":8005")
}
