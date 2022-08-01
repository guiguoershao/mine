/* package main

import (
	"fmt"
)

func show(s string) {
	for i := 0; i < 2; i++ {
		fmt.Println(s)
	}
}

func main() {
	go show("java")
	// 主协程
	for i := 0; i < 2; i++ {
		// 切一下，再次分配任务
		// runtime.Gosched() // 注释掉查看结果
		fmt.Println("golang")

	}
	fmt.Println("end...")
}
*/
package main

import (
	"fmt"
	"runtime"
	"time"
)

func a() {
	for i := 1; i < 10; i++ {
		fmt.Println("A:", i)
	}
}

func b() {
	for i := 1; i < 10; i++ {
		fmt.Println("B:", i)
	}
}

func main() {
	fmt.Printf("runtime.NumCPU(): %v\n", runtime.NumCPU())
	runtime.GOMAXPROCS(2) // 修改为1查看效果
	go a()
	go b()
	time.Sleep(time.Second)
}
