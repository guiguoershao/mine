package main

import "fmt"

/***
**建造者模式
**/
type Builder interface {
	buildDisk()
	buildCPU()
	buildRom()
}

type SuperComputer struct {
	Name string
}

func (this *SuperComputer) buildDisk() {
	fmt.Println("超大硬盘")
}
func (this *SuperComputer) buildCPU() {
	fmt.Println("超快CPU")
}
func (this *SuperComputer) buildRom() {
	fmt.Println("超大内存")
}

type LowComputer struct {
	Name string
}

func (this *LowComputer) buildDisk() {
	fmt.Println("超小硬盘")
}

func (this *LowComputer) buildCPU() {
	fmt.Println("超慢CPU")
}

func (this *LowComputer) buildRom() {
	fmt.Println("超小内存")
}

type Drictor struct {
	builder Builder
}

func NewConstruct(b Builder) *Drictor {
	return &Drictor{
		builder: b,
	}
}

func (this *Drictor) Consturct() {
	this.builder.buildDisk()
	this.builder.buildCPU()
	this.builder.buildRom()
}

func main() {
	sc := SuperComputer{}
	d := NewConstruct(&sc)
	d.Consturct()

	fmt.Println("--------------------")

	lc := LowComputer{}
	d2 := NewConstruct(&lc)
	d2.Consturct()
}
