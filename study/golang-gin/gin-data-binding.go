package main

import (
	"github.com/gin-gonic/gin"
	"log"
)

type User struct {
	Username string `form:"username"`
	Password string `form:"password"`
	//Hobby    []string `form:"hobby"`
	//Gender   string   `form:"gender"`
	//City     string   `form:"city"`
}

func GoRegister(c *gin.Context) {
	c.HTML(200, "register.html", nil)
}

func Regsiter(c *gin.Context) {
	var user User
	err := c.ShouldBind(&user)
	if err != nil {
		log.Fatal(err)
	}
	c.String(200, "User:%s", user)
}

// 绑定查询参数
func TestGetBind(c *gin.Context) {
	var user User
	err := c.ShouldBind(&user)
	if err != nil {
		log.Fatal(err)
	}
	c.String(200, "User: %s, password: %v", user, c.Query("password"))
}

func main() {
	e := gin.Default()
	e.LoadHTMLGlob("templates/*")
	e.POST("/register", Regsiter)
	e.GET("/register", GoRegister)

	e.GET("testGetBind", TestGetBind)

	e.Run(":8002")
}
