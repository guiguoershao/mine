package sys_core

import (
	"gin-mine/configs"
	"gin-mine/framework/console"
	"github.com/go-redis/redis/v9"
)

func RedisInstance() *redis.Client {
	redisConfig := configs.GetInstance().Entity.Redis
	rdb := redis.NewClient(&redis.Options{
		Addr:     redisConfig.Addr,
		Password: redisConfig.Password,
		DB:       redisConfig.Db,
	})
	console.Print("调试 redis:%v", rdb)

	return rdb
}
