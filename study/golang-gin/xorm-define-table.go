package main

import (
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"time"
	"xorm.io/xorm"
)

var engine *xorm.Engine

type LoginUser struct {
	Id      int64  `xorm:"pk autoincr"`
	Name    string `xorm:"varchar(25) notnull unique 'usr_name' comment('姓名')"`
	Salt    string
	Age     int
	Sex     string    `xorm:"varchar(10) comment('性别')"`
	Passwd  string    `xorm:"varchar(100) comment('密码')"`
	Created time.Time `xorm:"created comment('创建时间')"`
	Updated time.Time `xorm:"updated comment('更新时间')"`
}

func (lu LoginUser) TableName() string {
	return "golang_login_user"
}

func (lu LoginUser) TableComment() string {
	return "登录用户表"
}

func init() {
	var err error
	engine, err = xorm.NewEngine("mysql", "fengyan:k@wDNEoPGVPa0B7f@tcp(120.77.156.30:23306)/test_xorm?charset=utf8mb4&parseTime=True")
	if err != nil {
		fmt.Printf("err: %v\n", err)
		return
	}

	err2 := engine.Ping()
	if err2 != nil {
		fmt.Printf("err2: %v\n", err2)
		return
	}
	fmt.Println("连接数据库成功")
}

func main() {
	engine.ShowSQL(true)

	//engine.SetMapper(names.GonicMapper{})
	//engine.SetMapper(names.SnakeMapper{})
	//engine.SetMapper(names.SameMapper{})

	//tbMapper := names.NewPrefixMapper(names.SnakeMapper{}, "prefix_")
	//engine.SetTableMapper(tbMapper)

	//engine.SetMapper(names.SnakeMapper{})
	//err3 := engine.Sync(new(LoginUser))
	//fmt.Printf("err3: %v\n", err3)
	engine.Sync2(new(LoginUser))
}
