package main

import (
	"fmt"
	"github.com/gin-gonic/gin"
)

func TestMw(c *gin.Context) {
	c.String(200, "hello, %s", "冯火火")
}

func MyMiddleware1(c *gin.Context) {
	fmt.Println("我的第一个中间件")
}

func MyMiddleware2(c *gin.Context) {
	fmt.Println("我的第二个中间件")
}

func main() {
	e := gin.Default()
	e.Use(MyMiddleware1, MyMiddleware2)

	e.GET("/testmw", TestMw)

	e.Run(":8004")
}
