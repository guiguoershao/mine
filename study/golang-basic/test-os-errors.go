package main

import (
	"errors"
	"fmt"
	"time"
)

func check(s string) error {
	if s == "" {
		return errors.New("字符串不能为空")
	} else {
		return nil
	}
}

type MyError struct {
	When time.Time
	Whta string
}

func (e MyError) Error() string {
	return fmt.Sprintf("%v: %v", e.When, e.Whta)
}

func oops() error {
	return MyError{
		When: time.Date(1989, 3, 15, 22, 30, 0, 0, time.UTC),
		Whta: "the file system has gone away",
	}
}

func main() {
	/* check("hello")
	err := check("")
	fmt.Printf("err: %v\n", err.Error()) */

	if err := oops(); err != nil {
		fmt.Println(err)
	}
}
