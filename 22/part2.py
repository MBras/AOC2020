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

maxgame = 1

def playgame(player1, player2):
    round = 1
    global maxgame

    game = maxgame

    maxgame += 1

#    print "=== Game " + str(game) + " ===\n"
    
    p1hist = []
    p2hist = []

    while 1:
        print "-- Round " + str(round) + " (Game " + str(game) + ") --"

#        print "Player 1's deck: " + ", ".join(str(c) for c in player1)
#        print "Player 2's deck: " + ", ".join(str(c) for c in player2)

        # check deck reccurance
        if ",".join(str(c) for c in player1) in p1hist and ",".join(str(c) for c in player2) in p2hist:
#            print "Recurring config, player 1 wins!"
            return 1
        p1hist.append(",".join(str(c) for c in player1))
        p2hist.append(",".join(str(c) for c in player2))

        # draw cards
        c1 = player1.pop(0)
        c2 = player2.pop(0)
 #       print "Player 1 plays: " + str(c1)
 #       print "Player 2 plays: " + str(c2)

        # check stack heights
        if c1 <= len(player1) and c2 <= len(player2):
 #           print "Playing a sub-game to determine the winner..."
 #           print
            p1copy = player1[:c1:]
            p2copy = player2[:c2:]
            winner = playgame(p1copy, p2copy)
 #           print "The winner of game " + str(maxgame) + " is player " + str(winner) + "!"
 #           print
 #           print "...anyway, back to game " + str(game)
 #           print "Player " + str(winner) + " wins round " + str(round) + " of game " + str(game) + "!"
            if winner == 1:
                player1.append(c1)
                player1.append(c2)
            else:
                player2.append(c2)
                player2.append(c1)
        
        else:
           if c1 > c2:
 #               print "Player 1 wins round " + str(round) + " of game " + str(game) + "!"
                player1.append(c1)
                player1.append(c2)
           else:
 #               print "Player 2 wins round " + str(round) + " of game " + str(game) + "!"
                player2.append(c2)
                player2.append(c1)

        round += 1
    
        if len(player1) == 0:
            return 2
        elif len(player2) == 0:
            return 1

#        print

playgame(player1, player2)

print
print
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
