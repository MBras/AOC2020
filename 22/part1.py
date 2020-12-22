import re

lines = open("input.1").read()
lines = open("input.2").read()
#lines = open("input.3").read()
lines = lines.splitlines()

player1 = []
player2 = []

# cards player 1
for i in range(1, len(lines)):
    if lines[i] == "":
        break
    else:
        player1.append(int(lines[i]))

i += 2 
for i in range(i, len(lines)):
    player2.append(int(lines[i]))

round = 1
while 1:
    print "-- Round " + str(round) + " --"
    round += 1

    print "Player 1's deck: " + ", ".join(str(c) for c in player1)
    print "Player 2's deck: " + ", ".join(str(c) for c in player2)

    c1 = player1.pop(0)
    c2 = player2.pop(0)

    print "Player 1 plays: " + str(c1)
    print "Player 2 plays: " + str(c2)

    if c1 > c2:
        print "Player 1 wins the round!"
        player1.append(c1)
        player1.append(c2)
    else:
        print "Player 2 wins the round!"
        player2.append(c2)
        player2.append(c1)

    print

    if len(player1) == 0 or len(player2) == 0:
        break

print "== Post-game results =="
print "Player 1's deck: " + ", ".join(str(c) for c in player1)
print "Player 2's deck: " + ", ".join(str(c) for c in player2)

s1 = 0
for i in range(len(player1), 0, -1):
    s1 += i * player1.pop(0)
print "Player 1's score: " + str(s1)

s2 = 0
for i in range(len(player2), 0, -1):
    s2 += i * player2.pop(0)
print "Player 2's score: " + str(s2)
