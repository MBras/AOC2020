def playgame(inp):
    if len(inp) % 10000 == 0:
        print "size: " + str(len(inp))
    
    #print "input: " + str(inp)
    last = inp.pop()
    
    search = 1
    searchinp = inp[::-1]
    #print "looking for " + str(last) + " in " + str(searchinp)
    inp.append(last)
    try:
        search = searchinp.index(last)
        #print "Looking for: " + str(last) + ", found: " + str(search)
        inp.append(search + 1)
    except ValueError:
        #print "Looking for: " + str(last) + ", found nothing"
        inp.append(0)

#==============[ Part 1 ]==============
inp = [15,5,1,4,7,0]
for x in range(2020 - len(inp)):
    playgame(inp)
#print inp
print "Part 1: " + str(inp.pop())


#==============[ Part 2 ]==============

def prepinp(inp, numbers):
    # convert the input to an indexed array
    for x in range(len(inp)):
        numbers[inp[x]] = x
        print numbers

inp = [15,5,1,4,7]
nextvalue = 0
numbers = {}

prepinp(inp, numbers)

steps = 30000000

# loop for 30.000.000 steps
for turn in range (len(inp), steps - 1):
    if turn % 1000000 == 0:
        print "Turn " + str(turn + 1) + " looking for " + str(nextvalue)
    # check if the next value already exists
    if nextvalue in numbers:
        # if yes determine currentstep - value of key (difference) -> nextvalue 
        difference = turn - numbers[nextvalue]
        #print "Found " + str(nextvalue) + ", " + str(difference) + " steps ago"
        numbers[nextvalue] = turn
        nextvalue = difference
    else:
        # if no add it as key with value currentstep and proceed to check for 0 (nextvalue)
        #print "Didn't find " + str(nextvalue)
        numbers[nextvalue] = turn
        nextvalue = 0
# print numbers

print "Part 2: " + str(nextvalue)
