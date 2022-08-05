package main

import (
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"time"
	"xorm.io/xorm"
)

var engine *xorm.Engine

type BasicUser struct {
	Id      int    `xorm:"pk autoincr"`
	Name    string `xorm:"varchar(25) notnull unique 'usr_name' comment('姓名')"`
	Salt    string
	Age     int
	Sex     string    `xorm:"varchar(10) comment('性别')"`
	Passwd  string    `xorm:"varchar(100) comment('密码')"`
	Created time.Time `xorm:"created comment('创建时间')"`
	Updated time.Time `xorm:"updated comment('更新时间')"`
	Deleted time.Time `xorm:"deleted comment('删除时间')"`
}

func (lu BasicUser) TableName() string {
	return "basic_user"
}

func (lu BasicUser) TableComment() string {
	return "用户表"
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
	/*
		users := make([]BasicUser, 1)
		engine.Asc("id").Find(&users)
		fmt.Printf("users: %v\n", users)
	*/
	/*users := make([]BasicUser, 0)
	engine.Where("age = ?", 23).Find(&users)
	fmt.Printf("users: %v\n", users)

	for i, v := range users {
		fmt.Printf("i: %v, v: %v \n", i, v)
	}*/

	/*var user BasicUser
	engine.ID(1).Get(&user)
	fmt.Printf("user.name: %v\n", user.Name)
	*/

	/*user := &BasicUser{Id: 1}
	has, err := engine.Get(user)
	fmt.Printf("has: %v, err: %v, user.name: %v\n", has, err, user.Name)
	*/

	/*users := make([]BasicUser, 0)
	// Where("age > ? or name = ?", 30, "xlw")
	err := engine.Limit(10, 0).Find(&users)
	fmt.Printf("err: %v, user.name: %v\n", err, users)*/

	err := engine.Where("age > ?", 20).Iterate(new(BasicUser), func(idx int, bean interface{}) error {
		user := bean.(*BasicUser)
		fmt.Printf("idx: %v, user.name: %v\n", idx, user.Name)

		return fmt.Errorf("dfasdf")
	})
	println(err)
	println(1111111)
	if err != nil {
		fmt.Println(err)
	}
}
