package main

import (
	"bytes"
	"fmt"
)

func main() {
	var i int = 1
	var j byte = 2
	j = byte(i)
	fmt.Printf("j: %v\n", j)

	b := []byte("duoke360.com") // 字符串强转为byte切片
	sublice1 := []byte("duoke360")
	sublice2 := []byte("DuoKe360")
	fmt.Println(bytes.Contains(b, sublice1))
	fmt.Println(bytes.Contains(b, sublice2))

	s := []byte("hellooooooooo")
	sep1 := []byte("h")
	// sep2 := []byte("l")
	// sep3 := []byte("o")
	fmt.Println(bytes.Count(s, sep1))

}
