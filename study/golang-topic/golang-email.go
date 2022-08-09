package main

import (
	"fmt"
	"github.com/jordan-wright/email"
	"net/smtp"
	"time"
)

func main() {
	/*e := email.NewEmail()
	e.From = "鬼国二少 <1024882380@qq.com>"
	e.To = []string{"guiguoershao@163.com"}
	//e.Bcc = []string{"guiguoershao@qq.com"}
	e.Cc = []string{"guiguoershao@qq.com"} // 抄送
	e.Subject = "测试golang email库"
	e.Text = []byte("本文邮件内容!")
	e.HTML = []byte("<h1>html 邮件内容!</h1>")
	err := e.Send("smtp.qq.com:587", smtp.PlainAuth("", "1024882380@qq.com", "bmjwwerbxacobbji", "smtp.qq.com"))

	if err != nil {
		fmt.Printf(err.Error())
	}*/
	/*e := &email.Email{
		To: []string{"guiguoershao@163.com"},
		From: "鬼国二少 <1024882380@qq.com>",
		Subject: "Awesome Subject",
		Text: []byte("Text Body is, of course, supported!"),
		HTML: []byte("<h1>Fancy HTML is supported, too!</h1>"),
		Headers: textproto.MIMEHeader{},
	}
	e.AttachFile("a.txt")
	err := e.Send("smtp.qq.com:587", smtp.PlainAuth("", "1024882380@qq.com", "bmjwwerbxacobbji", "smtp.qq.com"))
	if err != nil {
		fmt.Printf(err.Error())
	}*/
}
