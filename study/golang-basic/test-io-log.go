package main

import (
	"log"
	"os"
)

var logger *log.Logger

func init() {
	logFile, err := os.OpenFile("log/a.log", os.O_CREATE|os.O_RDWR|os.O_APPEND, 0644)

	if err != nil {
		log.Panic("打开日志文件异常")
	}

	logger = log.New(logFile, "success", log.Ldate|log.Ltime|log.Lshortfile)
}
func main() {
	/* defer fmt.Println("发生了 panic错误！")

	log.Print("my log")
	log.Printf("my log %d", 100)
	name := "tom"
	age := 20
	log.Println(name, ",", age)
	// log.Panic("致命错误！")

	fmt.Println("end...") */

	/* i := log.Flags()
	fmt.Printf("i: %v\n", i)
	log.SetFlags(log.Ldate | log.Ltime | log.Llongfile | log.LUTC | log.Lmicroseconds)
	log.Print("my log")
	*/

	logger.Println("自定义logger")
}
