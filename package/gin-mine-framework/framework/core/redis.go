package core

import (
	"gin-mine/configs"
	"github.com/go-redis/redis/v9"
)

func RedisInstance() *redis.Client {
	redisConfig := configs.GetInstance().Entity.Redis
	rdb := redis.NewClient(&redis.Options{
		Addr:     redisConfig.Addr,
		Password: redisConfig.Password,
		DB:       redisConfig.Db,
	})

	return rdb
}
