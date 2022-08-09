package main

import (
	"errors"
	"fmt"
	"os"
)

func Div(a int, b int) (int, error) {
	if b == 0 {
		return -1, errors.New("除数不能为0")
	}

	return a / b, nil
}

func Open(name string) (*os.File, error) {
	return os.OpenFile(name, os.O_RDONLY, 0)
}

type MyError struct {
	error
	Msg  string
	Code int
}

func (e *MyError) Error() string {
	return e.Msg
}

func main() {
	/*_, err := os.Open("b.txt")
	fmt.Printf("err: %v\n", err.Error())
	*/

	/*_, err := Div(1, 0)
	fmt.Printf("err： %v \n", err)
	*/

	err := fmt.Errorf("not found mongodb config: %s", "出现错误")
	fmt.Printf("err: %v\n", err)
}
