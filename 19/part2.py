import re

lines = open("input.1").read()
#lines = open("input.2").read()
lines = lines.splitlines()

readingrules = 1
rules = {}
puzzles = []
for line in lines:
    if line == "": # rules and puzzles are seperated by an empty line
        readingrules = 0
    elif readingrules: # reading rules
        m = re.search('(\d*): (.*)', line)
        rules[m.group(1)] = m.group(2).replace("\"","")
    else: # reading puzzle pieces
        puzzles.append(line)

print "Rules:"
for key in sorted(rules):
    print str(key) + " => " + rules[key]

#print "Puzzles:"
#print puzzles

def genregexp(rule):
    #print "Processing: " + rule
    regexp = ""
    matches = re.findall("(\S+|\|)(?: )*", rule)
    #print matches
    # check for "|" in matches to include braces
    if "|" in matches:
        regexp += "(?:"
    for match in matches:
        # check for the silly replace thingies
        if match == "8":
            temp = "(?:" + genregexp(rules["42"]) + ")+"
            regexp += temp
        elif match == "11":
            temp = "(?:"
            for x in range(1, 10): # learned from github.com/shoop, because my solution of 
                                   # verifying if these two capture groups were equal in length didn't work
                temp += x * ("(?:" + genregexp(rules["42"]) + ")")
                temp += x * ("(?:" + genregexp(rules["31"]) + ")")
                temp += "|"
            temp = temp[:-1]
            temp += ")"
            regexp += temp
        else:
            try:
                #print "Found it, now looking for " + rules[match]
                regexp += genregexp(rules[match])
            except KeyError or ValueError:
                #print "Didn't find it, storing " + match
                regexp += match
    if "|" in matches:
        regexp += ")"
    
    return regexp

regexp = "^(" + genregexp(rules["0"]) + ")$"
print "Regexp: " + regexp

# counted with https://regex101.com/r/vcNmUG/2
# but ok, here's the python code to count valid strings
count = 0
for puzzle in puzzles:
    match = re.search(regexp, puzzle)
    if match:
        count += 1
        print "Match: " + puzzle
print "Part 2: " + str(count)
