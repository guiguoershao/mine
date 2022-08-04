package main

import "github.com/gin-gonic/gin"

// get 参数
func TestQueryString(c *gin.Context) {
	username := c.Query("username")
	site := c.DefaultQuery("site", "www.duoke360.com")
	c.String(200, "username:%s, site:%s", username, site)
}

// post参数
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

// 路径参数（restful风格）

func TestPathParam(c *gin.Context) {
	s := c.Param("username")
	c.String(200, "Username: %s", s)
}

// 既有get也有post
func TestGetAndPost(c *gin.Context) {
	page := c.DefaultQuery("page", "0")
	key := c.PostForm("key")
	c.String(200, "page:%s, key:%s", page, key)
}

func main() {
	e := gin.Default()
	e.LoadHTMLGlob("tempates/*")
	e.GET("/testQueryString", TestQueryString)

	e.GET("/login", Login)
	e.POST("/login", DoLogin)

	e.GET("/testPathParam/:username", TestPathParam)
	e.GET("/testGetAndPost", TestGetAndPost)
	e.Run(":8001")
}
