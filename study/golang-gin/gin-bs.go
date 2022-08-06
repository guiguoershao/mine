package main

import "github.com/gin-gonic/gin"

func GoStatic(e *gin.Context) {
	e.HTML(200, "test_static.html", nil)
}

func main() {
	e := gin.Default()
	e.Static("/assets", "./assets")
	e.LoadHTMLGlob("templates/*")

	e.GET("/go-static", GoStatic)
	e.Run(":8003")
}
