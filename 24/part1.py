import re

lines = open("input.1").read()
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
