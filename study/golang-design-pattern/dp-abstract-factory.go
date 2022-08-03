package main

import "fmt"

/***
**抽象工厂
**/

type Shape interface {
	Draw()
}

type Color interface {
	Fill()
}

// 实现模型接口的圆形类
type Circle struct {
}

// 实现模型接口的正方形类
type Square struct {
}

func (c Circle) Draw() {
	fmt.Println("画圆")
}

func (s Square) Draw() {
	fmt.Println("画正方形")
}

// red 实现色彩接口的红色类
type Red struct {
}

// green 实现色彩接口的绿色类
type Green struct {
}

func (r Red) Fill() {
	fmt.Println("填充红色")
}
func (g Green) Fill() {
	fmt.Println("填充绿色")
}

// 抽象工厂接口
type AbstractFactory interface {
	GetShape(shapeName string) Shape
	GetColor(colorName string) Color
}

// 模型工厂类
type ShapeFactory struct {
}

// 色彩工厂的类
type ColorFactory struct {
}

// 模型工厂实例获取模型子类的方法
func (sh ShapeFactory) GetShape(shapeName string) Shape {
	switch shapeName {
	case "circle":
		return &Circle{}
	case "square":
		return &Square{}
	default:
		return nil
	}
}

// 模型工厂实例不需要色彩的方法
func (sh ShapeFactory) GetColor(colorName string) Color {
	return nil
}

// 色彩工厂实例不需要获取模型方法
func (cf ColorFactory) GetShape(shapeName string) Shape {
	return nil
}

func (cf ColorFactory) GetColor(colorName string) Color {
	switch colorName {
	case "red":
		return &Red{}
	case "green":
		return &Green{}
	default:
		return nil
	}
}

// 超级工厂类 用于获取工厂实例
type FactoryProducer struct {
}

func (fp FactoryProducer) GetFactory(factoryname string) AbstractFactory {
	switch factoryname {
	case "color":
		return &ColorFactory{}
	case "shape":
		return &ShapeFactory{}
	default:
		return nil
	}
}

//NewFactoryProducer 创建FactoryProducer类
func NewFactoryProducer() *FactoryProducer {
	return &FactoryProducer{}
}

func main() {

	superFactory := NewFactoryProducer()
	colorFactory := superFactory.GetFactory("color")
	shapeFactory := superFactory.GetFactory("shape")

	red := colorFactory.GetColor("red")
	green := colorFactory.GetColor("green")

	circle := shapeFactory.GetShape("circle")
	square := shapeFactory.GetShape("square")

	// 红色的圆形
	circle.Draw()
	red.Fill()

	// 绿色的方形
	square.Draw()
	green.Fill()
}
