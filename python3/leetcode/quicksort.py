def findMinVal(list):
    min = list[0]
    for k in range(1, len(list)):
        if(list[k] < min):
            min = list[k]
    return min

my_list = [1,2,22,111,233,44,65,233,311]
print(findMinVal(my_list))