package main

import (
	"fmt"
	"github.com/gin-gonic/gin"
	"log"
	"net/http"
)

func Upload(c *gin.Context) {
	// 单文件
	file, _ := c.FormFile("file")
	log.Printf(file.Filename)

	// 上传文件到项目根目录，使用源文件名
	c.SaveUploadedFile(file, file.Filename)

	c.String(http.StatusOK, fmt.Sprintf("'%s' uploaded!", file.Filename))
}

func GoUpload(c *gin.Context) {
	c.HTML(200, "upload.html", nil)
}

func main() {
	router := gin.Default()
	// 为 multipart forms 设置较低的内存限制 (默认是 32 MiB)
	router.MaxMultipartMemory = 8 << 20
	router.LoadHTMLGlob("templates/*")

	router.GET("/upload", GoUpload)
	router.POST("/upload", Upload)

	router.Run(":8000")
}
