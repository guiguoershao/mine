package main

import "github.com/gin-gonic/gin"

func MyHandler(c *gin.Context) {
	c.JSON(200, gin.H{
		"hello": "Hello World",
	})
}

func Login(c *gin.Context) {
	c.HTML(200, "login.html", nil)
}

func DoLogin(c *gin.Context) {
	username := c.PostForm("username")
	password := c.PostForm("password")

	c.HTML(200, "welcome.html", gin.H{
		"username": username,
		"password": password,
	})
}

func main() {
	e := gin.Default()
	e.LoadHTMLGlob("templates/*")

	e.GET("/login", Login)
	e.POST("/login", DoLogin)
	e.Run(":8001")
}
