package main

import (
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"time"
	"xorm.io/xorm"
)

var engine *xorm.Engine

var err error

type User struct {
	Id      int64
	Name    string
	Salt    string
	Age     int
	Passwd  string    `xorm:"varchar(200)"`
	Created time.Time `xorm:"created"`
	Updated time.Time `xorm:"updated"`
}

func main() {
	engine, err = xorm.NewEngine("mysql", "fengyan:k@wDNEoPGVPa0B7f@tcp(120.77.156.30:23306)/test_xorm?charset=utf8mb4&parseTime=True")
	if err != nil {
		fmt.Printf("err: %v\n", err)
	} else {
		err2 := engine.Ping()
		if err2 != nil {
			fmt.Printf("err2: %v\n", err2)
		} else {
			fmt.Println("连接成功!")
		}
	}

	//	创建表
	err3 := engine.Sync(new(User))
	fmt.Printf("err3: %v\n", err3)

	// 添加数据
	user := User{
		Id:     1,
		Name:   "老郭",
		Salt:   "salt",
		Age:    100,
		Passwd: "123",
	}
	affected, _ := engine.Insert(&user)
	fmt.Printf("affected: %v\n", affected)
}
