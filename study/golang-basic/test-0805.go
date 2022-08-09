package main

import "fmt"

func main() {

	person, err := NewPerson("tom", 0)
	if err == nil {
		fmt.Printf("person: %v\n", *person)
	} else {
		fmt.Println(err)
	}
}

type Person struct {
	name string
	age  int
}

func NewPerson(name string, age int) (*Person, error) {
	if name == "" {
		return nil, fmt.Errorf("name 不能为空")
	}
	if age <= 0 {
		return nil, fmt.Errorf("age 不能小于0")
	}

	return &Person{name: name, age: age}, nil
}
