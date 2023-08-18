import turtle

# 隐藏画笔
turtle.hideturtle()
# 更改背景为黑色
turtle.bgcolor('black')

# 画笔粗细调整
turtle.pensize(3)

# 最外层
turtle.penup()
turtle.goto(325, 0)
turtle.left(90)
turtle.pendown()
turtle.color('red')
turtle.begin_fill()
turtle.circle(325)
turtle.end_fill()
turtle.right(90)


turtle.penup()
turtle.goto(275, 0)
turtle.left(90)
turtle.pendown()
turtle.color('white')
turtle.begin_fill()
turtle.circle(275)
turtle.end_fill()
turtle.right(90)


turtle.penup()
turtle.goto(225, 0)
turtle.left(90)
turtle.pendown()
turtle.color('red')
turtle.begin_fill()
turtle.circle(225)
turtle.end_fill()
turtle.right(90)

# 画圆
turtle.penup()
turtle.goto(175, 0)
turtle.left(90)
turtle.pendown()

# 1.选颜色
turtle.color('blue')
turtle.begin_fill()
# 画封闭图形
turtle.circle(175)
turtle.end_fill()

# 画五角星
turtle.color('white')
turtle.begin_fill()
turtle.penup()
turtle.goto(-166, 54)
turtle.right(90)
turtle.pendown()
turtle.forward(333)
turtle.right(144)
turtle.forward(333)
turtle.right(144)
turtle.forward(333)
turtle.right(144)
turtle.forward(333)
turtle.right(144)
turtle.forward(333)
turtle.right(144)
turtle.end_fill()

