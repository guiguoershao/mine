import turtle,random

# turtle.bgcolor('black')
# turtle.color('white')

turtle.speed(0)
turtle.bgcolor('black')
turtle.color(0.5, 0.5, 0.5)


for i in range(50) :
    turtle.begin_fill()
    # 五角星边长
    len = random.randint(1, 60)
    # 五角星位置
    x = random.randint(-400, 400)
    y = random.randint(-300, 300)
    turtle.penup()
    turtle.goto(x, y)
    turtle.pendown()
    for j in range(5):
        turtle.forward(len)
        turtle.right(144)
    turtle.end_fill()
    # 随机位置
    angle = random.randint(0, 360)
    turtle.setheading(angle) # 设置头的朝向