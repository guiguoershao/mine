package main

import (
	"context"
	"fmt"
	"github.com/go-redis/redis/v9"
)

var ctx = context.Background()

func ExampleClient() {
	rdb := redis.NewClient(&redis.Options{
		Addr:     "120.77.156.30:26379",
		Password: "rvEBhbJP9m@YmaKL",
		DB:       0,
	})
	fmt.Printf("连接redis成功: %v\n", rdb)
	err := rdb.Set(ctx, "name", "golang-teck-stack.com", 0).Err()
	if err != nil {
		fmt.Println(err)
		return
		//panic(err)
	}

	val, err := rdb.Get(ctx, "name").Result()
	if err != nil {
		fmt.Println(err)
		return
		//panic(err)
	}
	fmt.Println("name", val)

	val2, err := rdb.Get(ctx, "key2").Result()
	if err == redis.Nil {
		fmt.Println("key2 does not exist")
	} else if err != nil {
		fmt.Println(err)
		return
		//panic(err)
	} else {
		fmt.Println("key2", val2)
	}
	defer rdb.Close()
}

func main() {
	ExampleClient()
}
