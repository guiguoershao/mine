# 使用递归 找出列表中最大的数字。

def get_list_max(list):
    if (len(list) == 2) :
        return list[0] if list[0] > list[1] else list[1]
    max = get_list_max(list[1:])
    if list[0] > max:
        return list[0]
    else :
        return max
    
list = [1,2,3,4,5,6,7,8,9]
print(list[1:])
print(get_list_max(list))