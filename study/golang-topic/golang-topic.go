package main

import (
	"fmt"
	"reflect"
)

func main() {
	a := 100
	t := reflect.TypeOf(a)
	v := reflect.ValueOf(a)
	fmt.Printf("t :%v\n", t)
	fmt.Printf("v :%v\n", v)

}
