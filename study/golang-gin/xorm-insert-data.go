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
	//engine.ShowSQL(true)
	//engine.SetMapper(names.SnakeMapper{})
	//engine.Sync2(new(BasicUser))

	/*
		user := BasicUser{
			Name:   "冯炎4",
			Salt:   "我是冯火火",
			Age:    23,
			Sex:    "男",
			Passwd: "123456",
		}
		affected, err := engine.Insert(&user)
		if err != nil {
			fmt.Printf("err: %v\n", err)
			return
		}
		fmt.Printf("添加成功[%v]: %v\n", affected, user.Id)
	*/

	/*// 插入多条记录
	userList := make([]BasicUser, 5)
	for i := 0; i < 5; i++ {
		name := fmt.Sprintf("冯-%v", i)
		//fmt.Println(name)
		user := BasicUser{
			Name:   name,
			Salt:   "我是冯火火",
			Age:    23,
			Sex:    "男",
			Passwd: "123456",
		}
		userList[i] = user
	}
	fmt.Println(userList)
	engine.Insert(userList)
	for i, v := range userList {
		fmt.Printf("i: %v, v.id: %v, v.name: %v \n", i, v.Id, v.Name)
	}*/
}
