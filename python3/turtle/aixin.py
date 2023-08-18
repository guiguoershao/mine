import turtle
import random

turtle.setheading(45)


turtle.speed(0)
turtle.bgcolor(0,0,0)
turtle.hideturtle()

for i in range(100):
    r = random.random()
    g = random.random()
    b = random.random()
    size = random.randint(10, 20)
    turtle.color(1, g, b)

    angle = random.randint(0,360)
    turtle.setheading(angle)

    x = random.randint(-300, 300)
    y = random.randint(-300, 300)
    turtle.penup()
    print(x, y)
    turtle.goto(x, y)
    turtle.pendown()

    turtle.begin_fill()
    turtle.circle(size, 180)
    turtle.right(90)
    turtle.circle(size, 180)
    turtle.forward(size * 2)
    turtle.left(90)
    turtle.forward(size * 2)

    turtle.end_fill()
    
turtle.color(1, 1, 1)
turtle.penup()
turtle.goto(0, 300)
turtle.write("Dear xx, I love you!", align = "center", font = ("宋体", 10, "bold"))
turtle.pendown()
