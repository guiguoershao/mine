package main

import (
	"fmt"
	"github.com/spf13/viper"
)

// 读取 ini 配置
//noinspection ALL
func ReadIni() {
	v := viper.New()
	v.AddConfigPath("./conf")     // 路径
	v.SetConfigName("config.ini") // 名称
	v.SetConfigType("ini")        // 类型

	err := v.ReadInConfig() // 读配置
	if err != nil {
		panic(err)
	}
	s := v.GetString("db.username")
	fmt.Printf("s: %v \n", s)
}

//noinspection ALL
func ReadYml() {
	v := viper.New()
	v.AddConfigPath("./conf")
	v.SetConfigName("config")
	v.SetConfigType("yaml")

	err := v.ReadInConfig()

	if err != nil {
		panic(err)
	}

	s := v.Get("db.password")
	fmt.Printf("s: %v\n", s)
}

func main() {
	ReadIni()
	ReadYml()
}
