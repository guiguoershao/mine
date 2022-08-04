package main

import (
	"log"
	"net/http"
	"os"
	"text/template"
)

func test() {
	name := "world"
	templateStr := "Hello, {{.}}"
	t := template.New("test")
	t2, err := t.Parse(templateStr)
	if err != nil {

		log.Fatal(err)
	}

	t2.Execute(os.Stdout, name)
}

type Person struct {
	Name string
	Age  int
}

func test2() {
	ghz := Person{"ghz", 800}
	muban := "hello, {{.Name}}, Your age {{.Age}}"
	tmpl, err := template.New("test").Parse(muban)
	if err != nil {
		panic(err)
	}
	err = tmpl.Execute(os.Stdout, ghz)
	if err != nil {
		panic(err)
	}
}

func tmpl(w http.ResponseWriter, r *http.Request) {
	t1, err := template.ParseFiles("test.html")
	if err != nil {
		panic(err)
	}

	s := []string{"多渴望", "golang 教程", "老冯"}
	t1.Execute(w, s)
}

func httpServer() {
	server := http.Server{
		Addr: "127.0.0.1:8080",
	}

	http.HandleFunc("/tmpl", tmpl)
	server.ListenAndServe()
}

func main() {
	// test2()
	httpServer()
}
