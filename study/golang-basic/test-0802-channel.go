package main

import "fmt"

func main() {
	c := make(chan int)

	go func() {
		for i := 0; i < 10; i++ {
			c <- i
		}
		close(c)
	}()

	for {
		if data, ok := <-c; ok {
			fmt.Printf("data: %v\n", data)
		} else {
			break
		}
	}

	for v := range c {
		fmt.Printf("v: %v\n", v)
	}
}
