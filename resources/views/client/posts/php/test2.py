

def  flowing(a):
    pos=alphabet.index(a[0])
    is_fol = True
    for i in a:
        pos1 = alphabet.index(i)
        if pos1 < pos :
            is_fol= False
            break;
        pos = pos1
    return is_fol

def  recc(a):
    pos=alphabet.index(a[0])
    is_rec = True
    for i in a:
        pos1 = alphabet.index(i)
        if pos1 > pos :
            is_rec= False
            break;
        pos = pos1
    return is_rec



alphabet = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"]


count_flow = 0
count_rec = 0
count_tur = 0

count_t=0
for a in alphabet :
    t=["1","2","3","4","5"]
    t[0]=a
    for b in alphabet :
        t[1]=b
        for c in alphabet :
            t[2]=c
            for d in alphabet :
                t[3]=d
                count_t += 1
                for e in alphabet :
                    t[4]=e
                    count_t += 1
                    if flowing(t):
                        print(t)
                        count_flow += 1
                    elif recc(t):
                        print(t)
                        count_rec += 1
                    else:
                        count_tur += 1

print("count_flow: ",count_flow)
print("count_rec: ",count_rec)
print("count_tur: ",count_tur)

print(count_t)
print(count_flow+count_rec+count_tur)
