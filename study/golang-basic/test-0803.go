package main

import "fmt"

type USB interface {
	read()
	write()
}

type Computer struct {
}

type Mobile struct {
}

func (c Computer) read() {
	fmt.Println("computer read....")
}

func (c Computer) write() {
	fmt.Println("computer write...")

}

func (m Mobile) read() {
	fmt.Println("mobile read...")
}

func (m Mobile) write() {
	fmt.Println("mobile write...")
}

type Player interface {
	playMusic()
}

type Video interface {
	playVideo()
}

func (m Mobile) playMusic() {
	fmt.Println("播放音乐")

}

func (m Mobile) playVideo() {
	fmt.Println("播放视频")
}
func main() {
	/* c := Computer{}
	m := Mobile{}

	c.read()
	c.write()

	fmt.Println("------------------")
	m.read()
	m.write() */

	m := Mobile{}
	m.playMusic()
	m.playVideo()
}
