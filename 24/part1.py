import re

#lines = open("input.1").read()
lines = open("input.2").read()
lines = lines.splitlines()

moves = {}
moves["nw"] = [-1, -1]
moves["ne"] = [ 0, -1]
moves["w"]  = [-1,  0]
moves["e"]  = [ 1,  0]
moves["sw"] = [ 0,  1]
moves["se"] = [ 1,  1]

tiles = {}

def fliptile(tile):
    if tile == "B":
        tile = "W"
    else:
        tile = "B"
    return tile

for line in lines:
    regexp = "(e|w|nw|ne|sw|se)"
    m = re.findall(regexp, line)

    position = [0, 0]
    for instruction in m:
        position = [pos1 + pos2 for pos1, pos2 in zip(position, moves[instruction])]
    try:
        tiles[position[0], position[1]] = fliptile(tiles[position[0], position[1]])
    except KeyError:
        tiles[position[0], position[1]] = "B"


for key in tiles:
    print str(key) + ": " + str(tiles[key])

print "Part 1: " + str(sum(value == "B" for value in tiles.values()))


def countblack(t, x, y):
    b = 0
    for m in moves.values():
        try:
            if t[x + m[0], y + m[1]] == "B":
                #print "black at ",
                #print [x + m[0], y + m[1]]
                b += 1
            else:
                #print "white at ",
                #print [x + m[0], y + m[1]]
                pass
        except KeyError: # non exisiting tiles start out as white
            #print "white at ",
            #print [x + m[0], y + m[1]]
            pass

    return b

def gol(t):
    minx = min(t)[0] - 2
    maxx = max(t)[0] + 2
    miny = min(t)[1] - 2
    maxy = max(t)[1] + 2
    #print [minx, maxx, miny, maxy]

    temptiles = t.copy()
    for x in range(minx, maxx):
        for y in range(miny, maxy):
            black = countblack(t, x, y)
            try:
                if t[x, y] == "B" and (black == 0 or black > 2):
                    temptiles[x, y] = "W"
                if t[x, y] == "W" and black == 2:
                    temptiles[x, y] = "B"
            except KeyError:
                if black == 2:
                    temptiles[x, y] = "B"
                else:
                    temptiles[x, y] = "W"
            #try:
            #    print "Tile (" + str(x) + "," + str(y) + ") was " + t[x, y] + " and becomes/remains " + temptiles[x, y] + " with " + str(black) + " black enighbours!"
            #except KeyError:
            #    print "Tile (" + str(x) + "," + str(y) + ") was W and becomes/remains " + temptiles[x, y] + " with " + str(black) + " black enighbours!"

    return temptiles

turns = 100

for turn in range(turns):
    # hex game of life
    tiles = gol(tiles)
    print "Day " + str(turn + 1) + ": " + str(sum(value == "B" for value in tiles.values()))
