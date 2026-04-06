def successor(list):
    successor_list = [0, 0, 0]
    # successor value in decimal
    decimal_val = 0
    for i, j in enumerate(list):
        decimal_val += j * 3**i
    successor_decimal = decimal_val + 1

    # convert to list  we start we division 9 , 3 and 1 3² 3¹ 3⁰
    if successor_decimal >= 9:
        rest = successor_decimal % 9
        div = successor_decimal // 9
        successor_list[2] = div
        successor_decimal = rest
    if successor_decimal >= 3:
        rest = successor_decimal % 3
        div = successor_decimal // 3
        successor_list[1] = div
        successor_decimal = rest
    if successor_decimal >= 1:
        rest = successor_decimal % 1
        div = successor_decimal // 1
        successor_list[0] = div
        successor_decimal = rest

    return successor_list


print(successor([2, 1, 0]))
# 1 3 9


def leq(list1 , list2):
    # decima l value of list1
    decimal_val_list1 = 0
    for i, j in enumerate(list1):
        decimal_val_list1 += j * 3**i

    # decima l value of list1
    decimal_val_list2 = 0
    for i, j in enumerate(list2):
        decimal_val_list2 += j * 3**i


    return decimal_val_list1 <= decimal_val_list2


print(leq([0,1,1],[2,0,1]))
# 1 3 9


def tritwise_min (list1 , list2):
    the_list_tritwise_min=[]
    for index,value in enumerate(list1):
        # check if the index is in the list
        if index<len(list2):
            # take the min value and push it it the table
            if value < list2[index]:
                the_list_tritwise_min.append(value)
            else :
                # list2[index] to get the value for list2
                the_list_tritwise_min.append(list2[index])


    return the_list_tritwise_min

print("s",tritwise_min([2,0,1],[0,1,1]))


def f(list1, list2):
    if leq(list1,list2):
        successor_list = list1
        while successor_list != list2:
            successor_list =successor(list1)
            list1=tritwise_min(list1,successor_list)
            successor_list = successor(successor_list)

    else:
        print ("list1 must be smaller than list2")
    return list1

print(f([2,0,1],[1,1,1]))


        # decimal_val_list2 = get_decimal(list2)
        # successor_decimal=0
