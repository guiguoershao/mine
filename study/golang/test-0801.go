package main

import (
	"fmt"
)

type User struct {
	Name    string
	Address string
}

func getNameAndAge() (string, int) {
	return "老冯", 30
}

func init() {
	fmt.Println("init")
}

func init() {
	fmt.Println("init2")
}

var a int = initVar()

func initVar() int {
	fmt.Println("init var...")
	return 100
}

func main() {
	/*
		s := user.Hello()
		fmt.Printf("s: %v\n", s)

		name, _ := getNameAndAge()

		fmt.Printf("name: %v\n", name)
	*/
	/*
		// 常量
		const PI float32 = 3.14

		fmt.Printf("PI: %v\n", PI)
	*/
	/* const (
		a1 = iota
		a2 = "sdf"
		a3
	)

	fmt.Printf("a1: %v, a2: %v a3: %v\n", a1, a2, a3) */

	//	字符串切片
	/* str := "hello world"
	n := 0
	m := 5
	fmt.Printf("n: %c, m: %v, n-m: %v\n", str[n], str[m], str[n:m])
	*/

	/* for i := 1; i <= 10; i++ {
		fmt.Printf("i: %v\n", i)
	}

	var a = [5]int{1, 2, 3, 4, 5}
	for i, v := range a {
		fmt.Printf("i: %v, v:%v\n", i, v)
	}
	*/
	/*
		var a = [3]int{1, 2, 3}
		var b = [2]bool{true, false}
		var c = [2]string{"tom", "kite"}

		fmt.Printf("a: %v\n", a)
		fmt.Printf("b: %v\n", b)
		fmt.Printf("c: %v\n", c)
	*/

	// 切片
	/* var names = []string{"tom", "kite"}
	var numbers = []int{1, 2, 3}

	fmt.Printf("len: %d cap: %d \n", len(names), cap(names))
	fmt.Printf("len: %d cap: %d\n", len(numbers), cap(numbers))

	s1 := []int{1, 2, 3, 4, 5}

	s1 = append(s1[:2], s1[3:]...)
	fmt.Printf("s1: %v \n", s1)
	*/

	// map
	/* m1 := make(map[string]string)
	m1["name"] = "tom"
	m1["age"] = "20"
	fmt.Printf("m1: %v\n", m1)

	m2 := map[string]string{
		"name":  "kite",
		"age":   "20",
		"email": "kite@gmail.com",
	}
	fmt.Printf("m2: %v\n", m2)

	fmt.Printf("m2[name] : %v\n", m2["name"])

	for i, v := range m2 {
		fmt.Printf("i=%v: v=%v\n", i, v)
	} */

	/* fmt.Printf("3+4=%v\n", sum(3, 4))

	fmt.Println("------------")
	f2("tom", 20, 1, 2, 3)

	fmt.Printf("1+2=%v\n", fun(1, 2, sum))

	max := func(a int, b int) int {
		if a > b {
			return a
		} else {
			return b
		}
	}

	i := max(1, 2)
	fmt.Printf("i: %v\n", i)

	// 自己执行
	func(a int, b int) {
		max := 0
		if a > b {
			max = a
		} else {
			max = b
		}
		fmt.Printf("max: %v\n", max)
	}(3, 2)
	*/

	// 闭包

	//  递归

	// defer
	/* fmt.Println("start")
	defer fmt.Println("step1")
	defer fmt.Println("step2")
	defer fmt.Println("step3")
	fmt.Println("end")
	*/

	/* var a int = 20 // 声明实际变量
	fmt.Printf("a 变量的值是: %v\n", a)
	var ip *int // 声明指针变量
	ip = &a     //* 指针变量的存储地址
	fmt.Printf("a 变量的地址是: %x\n", &a)
	//* 指针变量的存储地址
	fmt.Printf("ip 变量储存的指针地址: %x\n", ip)
	//* 使用指针访问值
	fmt.Printf("*ip 变量的值: %d\n", *ip)
	fmt.Printf("ip 变量的值是: %v\n", ip)
	*/

	/* kite := Person{
		id:    1,
		name:  "kite",
		age:   20,
		email: "kite@gmail.com",
	}
	fmt.Printf("kite: %v\n", kite) */
	/*
		type Person struct {
			id   int
			name string
		}

		var tom = Person{1, "tom"}

		var p_person *Person
		p_person = &tom
		fmt.Printf("tom: %v\n", tom)
		fmt.Printf("p_person: %p\n", p_person)
		fmt.Printf("*p_person: %v\n", *p_person)
	*/

	/* type Person struct {
		id   int
		name string
	}

	var p_person = new(Person)
	fmt.Printf("p_person: %T\n", p_person)

	p_person.id = 1
	p_person.name = "tom"
	fmt.Printf("*p_person: %v\n", *p_person)
	*/

	person := Person{1, "tom"}
	fmt.Printf("person: %v\n", person)
	fmt.Println("--------------------")
	showPerson(&person)
	fmt.Println("---------------------")
	fmt.Printf("person : %v\n", person)
}

type Person struct {
	id   int
	name string
}

func showPerson(person *Person) {
	person.id = 1
	person.name = "kite"
	fmt.Printf("person: %v\n", person)
}

func sum(a int, b int) (ret int) {
	return a + b
}

func fun(a int, b int, f func(a int, b int) (ret int)) (ret int) {
	return f(a, b)
}

func f2(name string, age int, args ...int) {
	fmt.Printf("name: %v\n", name)
	fmt.Printf("age: %v\n", age)
	for _, v := range args {
		fmt.Printf("v: %v\n", v)
	}
}
