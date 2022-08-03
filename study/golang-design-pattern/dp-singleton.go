package main

import (
	"fmt"
	"sync"
)

type Singleton interface {
	dosomething()
}

// 首写字母小写 私有的 不能导出
type singleton struct {
}

func (s *singleton) dosomething() {
	fmt.Println("do some thing")
}

var (
	once     sync.Once
	instance *singleton
)

func GetInstance() Singleton {
	once.Do(
		func() {
			instance = &singleton{}
		},
	)
	return instance
}

func main() {
	s1 := GetInstance()
	fmt.Printf("s1: %p\n", s1)
	s2 := GetInstance()
	fmt.Printf("s2: %p\n", s2)
}
