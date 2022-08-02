package main

import (
	"encoding/json"
	"fmt"
)

type Person struct {
	Name  string
	Age   int
	Email string
}

func Marshal() {
	p := Person{
		Name:  "tom",
		Age:   20,
		Email: "tom@gmail.com",
	}
	b, _ := json.Marshal(p)
	fmt.Printf("b: %v\n", string(b))
}

func Unmarshal() {
	b1 := []byte(`{"Name":"tom","Age":20,"Email":"tom@gmail.com"}`)
	var m Person
	json.Unmarshal(b1, &m)
	fmt.Printf("m: %v\n", m)
}

func main() {
	Marshal()

	Unmarshal()
}
