package main

import (
	"bytes"
	"github.com/dchest/captcha"
	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/cookie"
	"github.com/gin-gonic/gin"
	"net/http"
	"time"
)

//	配置session
func SessionConfig() sessions.Store {
	sessionMaxAge := 3600
	sessionSecret := "golang-tech-stack"
	store := cookie.NewStore([]byte(sessionSecret))
	store.Options(sessions.Options{
		MaxAge: sessionMaxAge, // session生命周期
		Path:   "/",
	})
	return store
}

// 中间件 处理session
func Session(KeyPairs string) gin.HandlerFunc {
	store := SessionConfig()
	return sessions.Sessions(KeyPairs, store)
}

func Serve(w http.ResponseWriter, r *http.Request, id, ext, lang string, download bool, width, height int) error {
	w.Header().Set("Cache-Control", "no-cache, no-store, must-revalidate")
	w.Header().Set("Pragma", "no-cache")
	w.Header().Set("Expires", "0")

	var content bytes.Buffer

	switch ext {
	case ".png":
		w.Header().Set("Content-Type", "image/png")
		_ = captcha.WriteImage(&content, id, width, height)
	case ".wav":
		w.Header().Set("Content-Type", "audio/x-mav")
		_ = captcha.WriteAudio(&content, id, lang)
	default:
		return captcha.ErrNotFound
	}
	if download {
		w.Header().Set("Content-Type", "application/octet-stream")
	}
	http.ServeContent(w, r, id+ext, time.Time{}, bytes.NewReader(content.Bytes()))
	return nil
}

// @param length 验证码长度
func Captcha(c *gin.Context, l, w, h int) {
	//l := captcha.DefaultLen
	//w, h := 107, 36
	// 验证码随机数值
	captchaId := captcha.NewLen(l)
	session := sessions.Default(c)
	//	保存在session中
	session.Set("captcha", captchaId)
	_ = session.Save()
	_ = Serve(c.Writer, c.Request, captchaId, ".png", "zh", false, w, h)
}

//	验证

func CaptchaVerify(c *gin.Context, code string) bool {
	session := sessions.Default(c)
	if captchaId := session.Get("captcha"); captchaId != nil {
		session.Delete("captcha")
		_ = session.Save()
		if captcha.VerifyString(captchaId.(string), code) {
			return true
		} else {
			return false
		}
	} else {
		return false
	}
}

func main() {
	router := gin.Default()
	router.LoadHTMLGlob("./*.html")
	router.Use(Session("golang-tech-stack"))
	//	验证码生成页面
	router.GET("/captcha", func(c *gin.Context) {
		Captcha(c, 4, 107, 36)
	})

	router.GET("/index", func(c *gin.Context) {
		c.HTML(http.StatusOK, "captcha.html", nil)
	})

	router.POST("/captcha/verify/", func(c *gin.Context) {
		value := c.PostForm("code")
		if CaptchaVerify(c, value) {
			c.JSON(http.StatusOK, gin.H{"status": 0, "msg": "success"})
		} else {
			c.JSON(http.StatusOK, gin.H{"status": 1, "msg": "failed"})
		}
	})

	router.Run(":8001")
}
