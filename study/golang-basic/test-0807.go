package main

import (
	"fmt"
	"math/rand"
	"time"
)

var values = make(chan int)

func send() {
	rand.Seed(time.Now().UnixNano())
	value := rand.Intn(10)

	// value := 100

	fmt.Printf("send: %v\n", value)

	values <- value
}

func main() {
	// 通道 channel

	defer close(values)

	go send()

	fmt.Println("wait...")
	value := <-values
	fmt.Printf("receive: %v\n", value)
	fmt.Println("end...")
}
