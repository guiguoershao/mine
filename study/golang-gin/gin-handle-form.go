package main

import "github.com/gin-gonic/gin"

func Regsiter(c *gin.Context) {
	username := c.PostForm("username")
	password := c.PostForm("password")
	hobby := c.PostFormArray("hobby")
	gender := c.PostForm("gender")
	city := c.PostForm("city")

	c.String(200, "Username:%s, Password:%s, hobby:%s, gender:%s, city:%s", username, password, hobby, gender, city)

}

func GoRegister(c *gin.Context) {
	c.HTML(200, "register.html", nil)
}

func main() {
	e := gin.Default()
	e.LoadHTMLGlob("templates/*")
	e.POST("/register", Regsiter)
	e.GET("/register", GoRegister)
	e.Run("0.0.0.0:8002")
}
