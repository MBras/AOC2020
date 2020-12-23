cups = list("389125467")
cups = list("158937462")
moves = 100 

def printcups(p, c):
    print "cups: ",
    for x in range(len(c)):
        if x == p:
            print "(" + str(c[x]) + ") ",
        else:
            print str(c[x]) + " ",
    print

def printpickup(c):
    print "pick up: ",
    print ", ".join(c)
        

def playgame(p, c):
    # store cup list length
    #cl = len(c)
    maxc = max(c)

    # store current card to cycle back to
    current = c[p]
    
    # pick up three cards
    pickup = []
    for x in range(3):
        if p + 1 >= len(c):
            pickup.append(c.pop(0))
        else:
            pickup.append(c.pop(p+1))

    print "pick up: " + ", ".join(str(i) for i in pickup)

    # determine destination
    destination = current - 1
    while destination in pickup or destination == 0:
        destination = destination - 1
        if destination <= 0:
           destination = maxc 
    print "destination: " + str(destination)

    # place picked up cups
    i = c.index(destination) + 1
    c[i:i] = pickup

    # loop circle until current is current again
    while current <> c[p]:
        c.append(c.pop(0))
    
    return c

def final(c):
    i = c.index(1)
    return "".join(str(x) for x in (c[i + 1:len(c)] + c[0:i]))

# main loop
cups = [int(i) for i in cups] # convert to a list of numbers
for move in range(0, moves):
    print "-- move " + str(move + 1) + " --"
    printcups(move % len(cups), cups)
    cups = playgame(move % len(cups), cups)
    print

print "-- final --"
printcups((move  + 1) % len(cups), cups)
print "Part 1: " + final(cups)
