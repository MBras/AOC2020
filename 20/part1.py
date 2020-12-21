import re

lines = open("input.1").read()
#lines = open("input.2").read()
lines = lines.splitlines()

dirs = {0: "top", 1: "right", 2: "bottom", 3: "left"}

tiles = {}

#============[ print a given tile in a nice way
def printtile(t):
    for line in t:
        print "".join(line)
    print ""
        
#============[  check line vs the tile returning if it's found, in which direction and flipped or not
def cst(search, tile, x, y): 
    found = 1
    notfound = 0

    print "Checking"
    printtile(search)
    print "against"
    printtile(tile)

    # all sides to search for
    tops = "".join(search[0])
    rights = "".join([i[-1] for i in search])
    bottoms = "".join(search[-1])
    lefts = "".join([i[0] for i in search])
    
    # all sides  to search in
    top = "".join(tile[0])
    #print "top   : " + top
    right = "".join([i[-1] for i in tile])
    #print "right : " + right
    bottom = "".join(tile[-1])
    #print "bottom: " + bottom
    left = "".join([i[0] for i in tile])
    #print "left  : " + left

    if tops == bottom: # top matches bottom
        return found, search, x, y + 1
    if bottoms == top: # bottom matches top
        return found, search, x, y - 1
    if lefts = right: # left matches right
        return found, search, x - 1, y
    if rights = left: # right mathes left
        return found, search, x + 1, y
    
    

    return 0, 0, 0

#============[ main bit  

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

# start with the first tile in the middle at 0,0
resultkeys = {}
resulttiles = {}
resultkeys[0] = {}
resulttiles[0] = {}
resultkeys[0][0] = list(tiles.keys())[0]
resulttiles[0][0] = tiles.pop(list(tiles.keys())[0])

# while not all tiles have been matched
while len(tiles) > 0:
    # loop over the remaining tiles
    for key in tiles.keys():
        # check the tile against all tiles in the resultset
        print "Checking tile " + key + ": "
        printtile(tiles[key])
        for xkey in resulttiles.keys():
            for ykey, tile in resulttiles[xkey].items():
                print "against tile " + str(resultkeys[xkey][ykey])
                
                found, fixedtile = cst(tiles[key], tile, xkey, ykey)
