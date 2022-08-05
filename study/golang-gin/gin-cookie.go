package main

import (
	"fmt"
	"github.com/gin-gonic/gin"
)

func Handler(c *gin.Context) {
	// 获得cookie
	s, err := c.Cookie("username")
	fmt.Println(s)
	if err != nil {
		s = "这里是设置的cookie值"
		// 设置cookie
		c.SetCookie("username", s, 60*60, "/", "localhost", false, true)
	}

	c.String(200, "测试cookie")
}

func main() {
	e := gin.Default()
	e.GET("/test", Handler)
	e.Run(":8001")
}
