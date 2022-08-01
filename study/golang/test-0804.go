package main

import (
	"fmt"
)

type Pet interface {
	eat()
	sleep()
}

type Animal struct {
	name string
	age  int
}

type Dog struct {
	Animal
}

func (dog Dog) eat() {
	fmt.Println("dog eat...")
}

func (dog Dog) sleep() {
	fmt.Println("dog sleep...")
}

type Cat struct {
	Animal
}

func (cat Cat) eat() {
	fmt.Println("cat eat...")
}

func (cat Cat) sleep() {
	fmt.Println("cat sleep...")
}

type Person struct {
	name string
}

func (per Person) care(pet Pet) {
	pet.eat()
	pet.sleep()
}

func main() {
	dog := Dog{Animal{name: "狗", age: 2}}
	cat := Cat{Animal{name: "猫", age: 1}}
	per := Person{}
	per.care(dog)
	per.care(cat)
}
