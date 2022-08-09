package main

import (
	"fmt"
	"os"
)

func openCloseFile() {
	// 只能读
	f, _ := os.Open("test/a.txt")
	fmt.Printf("f.Name(): %v\n", f.Name())

	// 根据第二个参数 可以读写或者创建
	f2, _ := os.OpenFile("test/a1.txt", os.O_RDWR|os.O_CREATE, 0755)
	fmt.Printf("f2.Name(): %v\n", f2.Name())

	err := f.Close()
	fmt.Printf("err: %v\n", err)
	err2 := f2.Close()
	fmt.Printf("err2: %v\n", err2)
}

func createFiles() {
	f, _ := os.Create("test/a2.txt")
	fmt.Printf("f.Name(): %v\n", f.Name())

	// 第一个参数 目录默认：Temp 第二个参数 文件名前缀
	f2, _ := os.CreateTemp("", "temp")
	fmt.Printf("f2.Name(): %v\n", f2.Name())
}

func readOps() {
	f, _ := os.Open("test/a.txt")
	f.Seek(0, 0)

	buf := make([]byte, 100)
	n, _ := f.Read(buf)

	fmt.Printf("n: %v\n", n)
	fmt.Printf("string(buf): %v\n", string(buf))
	f.Close()
}

func write() {
	f, _ := os.OpenFile("test/a.txt", os.O_RDWR|os.O_TRUNC, 0755)
	f.WriteString("hello golang\n")
	f.Close()
}

func writeString() {
	f, _ := os.OpenFile("test/a.txt", os.O_RDWR|os.O_APPEND, 0755)
	f.WriteString("hello java\n")
	f.Close()
}

func writeAt() {
	f, _ := os.OpenFile("test/a.txt", os.O_RDWR, 0755)
	f.WriteAt([]byte("aaa"), 0)
	f.Close()
}

func main() {
	// openCloseFile()
	// createFiles()
	// readOps()

	write()
	writeString()
	writeAt()
}
