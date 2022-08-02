package main

import (
	"fmt"
	"os"
)

func main() {

	// 获得当前正在运行的进程id
	fmt.Printf("os.Getpid(): %v\n", os.Getegid())

	// 父id
	fmt.Printf("os.Getppid(): %v\n", os.Getppid())

	// 设置新进程的属性
	attr := &os.ProcAttr{
		// files 指定新进程继承的活动文件对象
		// 前三个分别为，标准输入、标准输出、标准错误输出
		Files: []*os.File{os.Stdin, os.Stdout, os.Stderr},
		// 新进程的环境变量
		Env: os.Environ(),
	}
}
