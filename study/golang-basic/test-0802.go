package main

import "fmt"

type Dog struct {
	name  string
	color string
	age   int
}

type person struct {
	dog  Dog
	name string
	age  int
}

func main() {
	var tom person
	tom.dog.name = "花花"
	tom.dog.color = "黑白花"
	tom.dog.age = 2

	tom.name = "tom"
	tom.age = 20

	fmt.Printf("tom: %v\n", tom)
}
