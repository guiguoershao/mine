package main

import (
	"fmt"
	"io/ioutil"
	"log"
	"net/http"
)

func testGet() {
	url := "http://apis.juhe.cn/simpleWeather/query"
	url += "?city=%E9%87%8D%E5%BA%86&key=d8c834a8******cfe0fc03&key=d8c834a888e250821feb136bcfe0fc03"

	r, err := http.Get(url)
	if err != nil {
		log.Fatal(err)
	}

	defer r.Body.Close()

	b, _ := ioutil.ReadAll(r.Body)

	fmt.Printf("b: %v\n", string(b))
}

func main() {
	testGet()
}
