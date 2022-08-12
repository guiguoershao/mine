package configs

import (
	"gin-mine/framework/console"
	"github.com/spf13/viper"
	"sync"
)

const (
	configName = "config"
	configType = "ini"
	configPath = "."
)

type Config struct {
	viper  *viper.Viper
	Entity entity
}

type entity struct {
	App   app
	Log   log
	Mysql mysql
	Redis redis
}

var once sync.Once
var instance *Config

func NewConfig(Viper *viper.Viper) *Config {
	once.Do(func() {
		instance = &Config{viper: Viper}
	})
	return instance
}

func GetInstance() *Config {
	return instance
}

func (c *Config) SetConf() *Config {
	c.viper.AddConfigPath(configPath) // 路径
	c.viper.SetConfigName(configName) // 名称
	c.viper.SetConfigType(configType) // 类型
	return c
}

func (c *Config) ReadInConfig() {
	err := c.viper.ReadInConfig()

	if err != nil {
		_ = viper.SafeWriteConfig()
		console.Fatal("读取日志失败, err: %v", err.Error())
		return
	}

	entity := entity{}
	err = c.viper.Unmarshal(&entity)
	console.Print("entity: %v", entity)
	//c.viper.UnmarshalKey("mysql", &entity.Mysql)
	c.Entity = entity
	//fmt.Printf("entity.mysql：%v\n", c.GetString("mysql.dsn"))
	//fmt.Printf("entity.mysql.username：%v, %v\n", c.Entity.Mysql.User, c.GetString("mysql.dsn"))
}

func (c Config) GetString(key string) string {
	return c.viper.GetString(key)
}
