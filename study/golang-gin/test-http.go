package main

import (
	"bytes"
	"encoding/json"
	"fmt"
	"io"
	"io/ioutil"
	"log"
	"net/http"
	"net/url"
	"strings"
	"sync"
	"time"
)

func testGet() {
	url := "http://apis.juhe.cn/simpleWeather/query"
	url += "?city=%E9%87%8D%E5%BA%86&key=d8c834a888e250821feb136bcfe0fc03"

	r, err := http.Get(url)
	if err != nil {
		log.Fatal(err)
	}

	defer r.Body.Close()

	b, _ := ioutil.ReadAll(r.Body)

	fmt.Printf("b: %v\n", string(b))
}

func testGet2() {
	params := url.Values{}
	Url, err := url.Parse("http://apis.juhe.cn/simpleWeather/query")
	if err != nil {
		return
	}
	params.Set("key", "d8c834a888e250821feb136bcfe0fc03")
	params.Set("city", "重庆")

	// 如果参数中又中文，这个方法会进行URLEncode
	Url.RawQuery = params.Encode()
	urlPath := Url.String()
	fmt.Printf("Url: %v\n", urlPath)

	resp, err := http.Get(urlPath)

	if err != nil {
		log.Fatal(err)
	}

	defer resp.Body.Close()

	body, _ := ioutil.ReadAll(resp.Body)
	fmt.Println(string(body))
}

func testParseJson() {
	type result struct {
		Args    string            `json:"args"`
		Headers map[string]string `json:"headers"`
		Origin  string            `json:"origin"`
		Url     string            `json:"url"`
	}

	resp, err := http.Get("http://bin.org/get")
	log.Fatal(err)
	if err != nil {
		return
	}

	defer resp.Body.Close()

	body, _ := ioutil.ReadAll(resp.Body)
	fmt.Printf("body: %v\n", string(body))
	var res result
	_ = json.Unmarshal(body, &res)
	fmt.Printf("%#v", res)
}

func testAddHeader() {

	url := "http://apis.juhe.cn/simpleWeather/query"
	url += "?city=%E9%87%8D%E5%BA%86&key=d8c834a888e250821feb136bcfe0fc03"

	client := &http.Client{}

	req, _ := http.NewRequest("GET", url, nil)

	req.Header.Add("name", "test")
	req.Header.Add("age", "80")

	resp, _ := client.Do(req)

	body, _ := ioutil.ReadAll(resp.Body)

	fmt.Printf("body: %v\n", string(body))

}

func testPost() {
	path := "http://apis.juhe.cn/simpleWeather/query"
	urlValues := url.Values{}
	urlValues.Add("key", "d8c834a888e250821feb136bcfe0fc03")
	urlValues.Add("city", "重庆")
	r, err := http.PostForm(path, urlValues)
	if err != nil {
		log.Fatal(err)
	}

	defer r.Body.Close()

	b, _ := ioutil.ReadAll(r.Body)
	fmt.Printf("b: %v\n", string(b))
}

func testPost2() {
	urlValues := url.Values{
		"name": {"火火"},
		"age":  {"80"},
	}
	reqBody := urlValues.Encode()

	resp, _ := http.Post("https://httpbingo.org/post", "text/html", strings.NewReader(reqBody))

	body, _ := ioutil.ReadAll(resp.Body)

	fmt.Println(string(body))

}

func testPostJson() {

	type result struct {
		Args    string            `json:"args"`
		Headers map[string]string `json:"headers"`
		Origin  string            `json:"origin"`
		Url     string            `json:"url"`
	}

	data := make(map[string]interface{})

	data["site"] = "www.duoke360.com"
	data["name"] = "多课网"

	bytesData, _ := json.Marshal(data)

	resp, _ := http.Post("https://httpbingo.org/post", "application/json", bytes.NewReader(bytesData))

	body, _ := ioutil.ReadAll(resp.Body)

	fmt.Println(string(body))

	var res result
	_ = json.Unmarshal(body, &res)
	fmt.Printf("%#v", res)
}

func testClient() {
	client := http.Client{
		Timeout: time.Second * 10,
	}
	url := "http://apis.juhe.cn/simpleWeather/query?key=087d7d10f700d20e27bb753cd806e40b&city=北京"

	req, err := http.NewRequest(http.MethodGet, url, nil)
	if err != nil {
		log.Fatal(err)
	}

	req.Header.Add("referer", "http://apis.juhe.cn/")
	res, err2 := client.Do(req)
	if err2 != nil {
		log.Fatal(err2)
	}

	defer res.Body.Close()
	b, _ := ioutil.ReadAll(res.Body)
	fmt.Printf("b: %v\n", string(b))
}

/// http server
func testHttpServer() {
	f := func(resp http.ResponseWriter, req *http.Request) {
		io.WriteString(resp, "Hello world")
	}
	// 响应路径, 注意前面要有斜杠
	http.HandleFunc("/hello", f)

	// 设置监听端口，并监听，注意前面要有冒号
	err := http.ListenAndServe(":9999", nil)
	if err != nil {
		log.Fatal(err)
	}
}

// 使用handler实现并发处理
type countHandler struct {
	mu sync.Mutex // guards n
	n  int
}

func (h *countHandler) ServeHTTP(w http.ResponseWriter, r *http.Request) {
	h.mu.Lock()
	defer h.mu.Unlock()
	h.n++
	fmt.Fprintf(w, "count is %d\n", h.n)
}

func testHttpServer2() {
	http.Handle("/count", new(countHandler))
	log.Fatal(http.ListenAndServe(":8080", nil))
}

func main() {
	// testGet()
	// testGet2()
	// testParseJson()
	// testAddHeader()
	// testPost2()
	// testPostJson()
	// testClient()
	// testHttpServer()
	testHttpServer2()
}
