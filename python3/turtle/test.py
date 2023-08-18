import time,turtle

# for i in range(1000) :
#     print(i, "杨燚...")
#     time.sleep(0.001)
    

# i = 1;
# while True:
#     print(i, "杨燚...")
#     time.sleep(0.001)
#     i += 1
#     if i > 1000 :
#         break;

# turtle.speed(10) # 画笔速度 
# i = 1
# while True:
#     turtle.circle(i)
#     i += 1
#     time.sleep(0.0001)
#     if i > 10000 :
#         break


turtle.bgcolor('black')
turtle.color('white')

turtle.penup()
turtle.goto(0, -300)
turtle.pendown()

for i in range(12) :
    turtle.begin_fill()
    for j in range(5):
        turtle.forward(60)
        turtle.right(144)
    turtle.end_fill()
    turtle.forward(60)
    turtle.penup() # 台笔
    turtle.circle(300, 360/12) # 走1/12的圆弧
    turtle.pendown()