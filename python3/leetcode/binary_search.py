# 二分查找算法 log2n 
# 对数是幂运算的逆运算
def binary_search(list, item) :
    low = 0
    high = len(list) - 1

    while (low <= high) :
        mid = (high + low) // 2
        guess = list[mid]
        print(mid, low, high, guess, item)
        if guess > item:
            high = mid - 1
        elif guess < item:
            low = mid + 1
        else:
            return mid
    
    return None

my_list = [1, 3, 5, 7, 9, 4, 2, 6]
my_list.sort()
print(my_list)
print(binary_search(my_list, 3))