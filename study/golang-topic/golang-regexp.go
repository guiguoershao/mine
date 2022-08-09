package main

import (
	"fmt"
	"regexp"
)

func main() {
	// 匹配
	match, _ := regexp.MatchString("H(.*)", "Hello world!")
	fmt.Println(match)
	fmt.Println("--------------------------")

	// 查找
	re := regexp.MustCompile(`foo.?`)
	fmt.Printf("%q \n", re.FindString("seafood fool"))
	fmt.Printf("%q \n", re.FindString("meat"))
	fmt.Println("--------------------------")
}
