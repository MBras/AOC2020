import re

lines = open("input.1").read()
lines = open("input.2").read()
lines = lines.splitlines()

dirs = {0: "top", 1: "right", 2: "bottom", 3: "left"}

tiles = {}

#============[ print a given tile in a nice way
def printtile(name, data):
    print "Tile: " + name
    print('\n'.join(map(''.join, data)))
    print ""

#============[ Print the puzzle nicely
def printpuzzle(keys, tiles):
    print "Completed puzzle:"
   
    for y in sorted(keys[0]):
        for x in sorted(keys):
            print keys[x][y],
        print

    for y in sorted(tiles[0]):
        for tilex in range(len(tiles[0][0])):
            for x in sorted(tiles):
                print "".join(tiles[x][y][tilex]),
            print
        print

def printpuzzle2(tiles):
    for y in sorted(tiles[0]):
        for tilex in range(len(tiles[0][0])):
            for x in sorted(tiles):
                print "".join(tiles[x][y][tilex]),
            print 
        print



#============[ functions to manipulate tiles

def rotatetile(t, steps): # rorate the tile [steps] times clockwise 90 degrees
    for i in range(steps):
        temptile = []
        for x in range(len(t)):
            temptile.append([i[x] for i in t][::-1])

        t = temptile
    return t

def fliphtile(t): # flip the tile horizontally
    temptile = []
    for line in t:
        temptile.append(line[::-1])
    return temptile

def flipvtile(t): # flip the tile vertically
    temptile = []
    for line in t[::-1]:
        temptile.append(line)
    return temptile


#============[ check all sides of both tiles, and also in reverse
def matchtile(t2, t1):
    # t2 is fixed in the results
    # t1 ios the flexible tile we try to match
    sides1 = []
    sides2 = []

    transformation = {}
    # fliph, flipv, rotation
    transformation[0]  = [1,0,2]
    transformation[1]  = [0,1,1]
    transformation[2]  = [0,0,0]
    transformation[3]  = [0,0,3]
    transformation[4]  = [0,0,2]
    transformation[5]  = []
    transformation[6]  = [1,0,0]
    transformation[7]  = [1,0,1]
    transformation[10] = [1,0,3]
    transformation[11] = [1,0,0]
    transformation[12] = []
    transformation[13] = [0,0,0]
    transformation[14] = [0,0,3]
    transformation[15] = [0,0,2] 
    transformation[16] = [1,0,1]
    transformation[17] = [0,1,0]
    transformation[20] = [0,0,0]
    transformation[21] = [0,0,3]
    transformation[22] = [0,1,0]
    transformation[23] = [0,1,1]
    transformation[24] = [1,0,0]
    transformation[25] = [1,0,1]
    transformation[26] = [0,0,2]
    transformation[27] = []
    transformation[30] = [0,0,1]
    transformation[31] = [0,0,0]
    transformation[32] = [1,0,3]
    transformation[33] = [1,0,0]
    transformation[34] = [1,0,1]
    transformation[35] = [0,1,0]
    transformation[36] = [0,0,3]
    transformation[37] = [0,0,2]

    #rotations = val2 + 4 - val1 % 4

    # all sides to search for
    sides1.append("".join(t1[0])) # top
    sides1.append("".join([i[-1] for i in t1])) # right
    sides1.append("".join(t1[-1])) # bottom
    sides1.append("".join([i[0] for i in t1])) # left
    # including reversed ones
    sides1.append("".join(t1[0])[::-1])
    sides1.append("".join([i[-1] for i in t1])[::-1])
    sides1.append("".join(t1[-1])[::-1])
    sides1.append("".join([i[0] for i in t1])[::-1])
    
    # all sides  to search in
    sides2.append("".join(t2[0]))
    sides2.append("".join([i[-1] for i in t2]))  
    sides2.append("".join(t2[-1]))
    sides2.append("".join([i[0] for i in t2]))

    for side1 in range(len(sides1)):
        for side2 in range(len(sides2)):
            if sides1[side1] == sides2[side2]:
                print "Found a match at the " + dirs[side2] + " (" + str(side2) + ") vs " + dirs[side1 % 4] + " (" + str(side1) + ")"

                printtile("Fixed tile", t2)
                printtile("Flex tile", t1)
                fliph, flipv, rotations = transformation[side2 * 10 + side1]
                if fliph:
                    t1 = fliphtile(t1)
                if flipv:
                    t1 = flipvtile(t1)
                t1 = rotatetile(t1, rotations)
                printtile("Flex tile updated", t1)

                return side2, t1 # returns values are the direction where the new tile should end up and the actual tile
    return -1, t1

#============[ Read data into the tiles dictionary
ct = 0 # currenttile
for line in lines:
    m = re.search('Tile (\d+):', line)
    if m:
        # new tile data found, start filling
        ct = m.group(1)
        tiles[ct] = []
        #print "found next tile " + ct
    elif line <> "":
        #print "filling tile " + ct
        tiles[ct].append([c for c in line])

#============[ Part 1 do over, now actually creating the puzzle

print "remaining tiles: " + str(len(tiles))

# start with the first tile in the middle at 0,0
resultkeys = {}
resulttiles = {}
resultkeys[0] = {}
resulttiles[0] = {}
resultkeys[0][0] = list(tiles.keys())[0]
resulttiles[0][0] = tiles.pop(list(tiles.keys())[0])

def matchtiles():
    # loop over the remaining tiles
    for key in tiles.keys():
        # check the tile against all tiles in the resultset
        for xkey in resulttiles.keys():
            for ykey, tile in resulttiles[xkey].items():
                #print "Checking tile " + str(resultkeys[xkey][ykey]) + " against " + key
                direction, tile = matchtile(tile, tiles[key])

                if direction >= 0:
                    if direction == 0:
                        # add th tile at the top
                        resulttiles[xkey][ykey - 1] = tile
                        resultkeys[xkey][ykey - 1] = key
                    elif direction == 1:
                        if xkey + 1 not in resulttiles:
                            resultkeys[xkey + 1] = {}
                            resulttiles[xkey + 1] = {}
                        resulttiles[xkey + 1][ykey] = tile
                        resultkeys[xkey + 1][ykey] = key
                    elif direction == 2:
                        resulttiles[xkey][ykey + 1] = tile
                        resultkeys[xkey][ykey + 1] = key
                    elif direction == 3:
                        if xkey - 1 not in resulttiles:
                            resultkeys[xkey - 1] = {}
                            resulttiles[xkey - 1] = {}
                        resulttiles[xkey - 1][ykey] = tile
                        resultkeys[xkey - 1][ykey] = key
                    del tiles[key]
                    return 

# while not all tiles have been matched
while len(tiles) > 0:
    matchtiles()

printpuzzle(resultkeys, resulttiles)

c1 = resultkeys[sorted(resultkeys)[0]][sorted(resultkeys[0])[0]]
c2 = resultkeys[sorted(resultkeys)[0]][sorted(resultkeys[0])[-1]]
c3 = resultkeys[sorted(resultkeys)[-1]][sorted(resultkeys[0])[0]]
c4 = resultkeys[sorted(resultkeys)[-1]][sorted(resultkeys[0])[-1]]

print "Part 1: " + str(int(c1) * int(c2) * int(c3) * int(c4))

# \o/

#============[ Part 2

# remove outside borders 
def removeborder(tile):
    blt = [] # borderless tile
    for line in tile[1:-1]:
        blt.append(line[1:-1])
    
    return blt

for x in resulttiles:
    for y in resulttiles[x]:
        resulttiles[x][y] = removeborder(resulttiles[x][y])

printpuzzle2(resulttiles)
