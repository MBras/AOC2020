import re

lines = open("input.1").read()
lines = open("input.2").read()
lines = lines.splitlines()

dirs = {0: "top", 1: "right", 2: "bottom", 3: "left"}

tiles = {}

#============[ print a given tile in a nice way
def printtile(name, data):
    print "Tile: " + name
    for line in data:
        print "".join(line)
    print ""

#============[ check all sides of both tiles, and also in reverse
def matchtile(t1, t2):
    sides1 = []
    sides2 = []

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

    for side1 in sides1:
        if side1 in sides2:
            print "Found a match!"
            return 1

    return 0
    

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

#============[ Match every tile vs every other tile and display matching sides
corners = []
for needle in tiles:
    matches = 0
    for haystack in tiles:
        if needle <> haystack:
            print "Comparing " + needle + " vs. " + haystack

            if matchtile(tiles[needle], tiles[haystack]):
                matches += 1
    print "  Found " + str(matches) + " matches."
    if matches == 2:
        # corners will have 2 matches
        print "  Corner found at " + needle
        corners.append(int(needle))

part1 = 1
for corner in corners:
    part1 *= corner

print "Part 1: " + str(part1)
