busses = "13,x,x,41,x,x,x,37,x,x,x,x,x,419,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,19,x,x,x,23,x,x,x,x,x,29,x,421,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,x,17"
busses = busses.split(",")

print(busses);

timestamp = 100000000000000

while 1:
    valid = 1

    if timestamp % 100000 == 0:
        print "Checking " + str(timestamp)
    
    for x in range(len(busses)):
        if busses[x] <> "x" and ((int(busses[x]) - (timestamp % int(busses[x]))) % int(busses[x])) != x:
            valid = 0
            break

    if valid: 
        print "Part 2 finished at " + str(timestamp)
        break
    
    timestamp += 1
