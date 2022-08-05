package main

import (
	"fmt"
	"github.com/gin-gonic/gin"
	"strconv"
)

type User struct {
	Uid  int    `json:"uid"`
	Name string `json:"name"`
	Age  int    `json:"age"`
}

var users = make([]User, 3)

func init() {
	u1 := User{1, "tom", 20}
	u2 := User{2, "kite", 30}
	u3 := User{3, "rose", 40}

	users = append(users, u1)
	users = append(users, u2)
	users = append(users, u3)

	fmt.Println(users)
}

func find(uid int) (*User, int) {
	for i, u := range users {
		if u.Uid == uid {
			return &u, i
		}
	}
	return nil, -1
}

func AddUser(c *gin.Context) {
	u4 := User{4, "joe", 50}
	users = append(users, u4)
	c.JSON(200, users)
}

func DelUser(c *gin.Context) {
	uid := c.Param("uid")
	id, _ := strconv.Atoi(uid)
	_, i := find(id)
	users = append(users[:i], users[i+1:]...)
	c.JSON(200, users)
}

func UpdateUser(c *gin.Context) {
	uid := c.Param("uid")
	id, _ := strconv.Atoi(uid)
	u, _ := find(id)
	u.Name = "修改的Name"
	c.JSON(200, u)
}

func FindUser(c *gin.Context) {
	uid := c.Param("uid")
	id, _ := strconv.Atoi(uid)
	u, _ := find(id)
	c.JSON(200, u)
}

func main() {
	e := gin.Default()
	e.GET("/user/:uid", FindUser)
	e.PUT("/user/:uid", UpdateUser)
	e.DELETE("/user/:uid", DelUser)
	e.POST("/user/", AddUser)
	e.Run(":8000")
}
