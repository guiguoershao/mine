package main

import (
	"fmt"
	"os"
)

func createFile() {
	f, err := os.Create("test.log")
	if err != nil {
		fmt.Printf("err: %v\n", err)
	} else {
		fmt.Printf("f: %v\n", f)
	}
}

func createDir() {
	err := os.MkdirAll("log", os.ModePerm)
	if err != nil {
		fmt.Printf("err: %v\n", err)
	}
}

func removeDir() {
	err := os.RemoveAll("log")
	if err != nil {
		fmt.Printf("err: %v\n", err)
	}
}

//	获得工作目录
func getWd() {
	dir, err := os.Getwd()
	if err != nil {
		fmt.Printf("err: %v\n", err)
	} else {
		fmt.Printf("dir: %v\n", dir)
	}
}

// 	修改工作目录
func chWd() {
	err := os.Chdir("D:/data/app/guiguoershao/mine/study")
	if err != nil {
		fmt.Printf("err: %v\n", err)
	}
	fmt.Println(os.Getwd())
}

// 获得临时目录
func getTemp() {
	s := os.TempDir()
	fmt.Println("临时目录: %v\n", s)
}

func renameFile() {
	err := os.Rename("test.log", "test-01.log")
	if err != nil {
		fmt.Printf("err: %v\n", err)
	}
}

func readFile() {
	b, err := os.ReadFile("test-01.log")

	if err != nil {
		fmt.Printf("err: %v\n", err)
	} else {
		fmt.Printf("b: %v\n", string(b[:]))
	}
}

func writeFile() {
	s := "hello world"
	os.WriteFile("test-01.log", []byte(s), os.ModePerm)
}

func main() {
	// createDir()
	// createFile()
	// removeDir()

	// getWd()
	// chWd()
	// renameFile()
	// writeFile()
	// readFile()
	// getTemp()
}
