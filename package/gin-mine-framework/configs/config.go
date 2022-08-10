package configs

import (
	"fmt"
	"github.com/spf13/viper"
	"sync"
)

type Config struct {
	Viper *viper.Viper
}

var once sync.Once
var instance *Config

func NewConfig(Viper *viper.Viper) *Config {
	once.Do(func() {
		instance = &Config{Viper: Viper}
	})
	return instance
}

func GetInstance() *Config {
	return instance
}

func (c Config) SetConf(path, name, t string) Config {
	c.Viper.AddConfigPath("./configs") // 路径
	c.Viper.SetConfigName("config")    // 名称
	c.Viper.SetConfigType(t)           // 类型
	return c
}

func (c Config) ReadInConfig() {
	err := c.Viper.ReadInConfig()

	if err != nil {
		fmt.Printf("读取日志失败")
		return
	}
}

func (c Config) GetString(key string) string {
	return c.Viper.GetString(key)
}
