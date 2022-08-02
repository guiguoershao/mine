package main

import (
	"fmt"
	"time"
)

func main() {
	/*
		timer := time.NewTimer(time.Second * 2)
		// t1 := time.Now()
		fmt.Printf("time.now: %v\n", time.Now())
		t1 := <-timer.C // 阻塞的 指定时间到了
		fmt.Printf("t1: %v\n", t1)
	*/

	timer := time.NewTimer(time.Second * 2)
	<-timer.C
	fmt.Printf("timer: %v\n", timer)
	fmt.Println("2s后")

	time.Sleep(time.Second * 2)
	fmt.Println("再一次2s后")

	<-time.After(time.Second * 2) // time.After 函数返回值是chan time
	fmt.Println("再再一次2s后")
}
