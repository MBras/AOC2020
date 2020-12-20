import re

lines = open("input.1").read()
lines = open("input.2").read()
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
            regexp += "(?:" + genregexp(rules["42"]) + ")+"
        elif match == "11":
            regexp += "((?:(?:" + genregexp(rules["42"]) + "){1}(?:" + genregexp(rules["31"]) + "){1})|"
            regexp += "(?:(?:" + genregexp(rules["42"]) + "){2}(?:" + genregexp(rules["31"]) + "){2})|"
            regexp += "(?:(?:" + genregexp(rules["42"]) + "){3}(?:" + genregexp(rules["31"]) + "){3})|"
            regexp += "(?:(?:" + genregexp(rules["42"]) + "){4}(?:" + genregexp(rules["31"]) + "){4})|"
            regexp += "(?:(?:" + genregexp(rules["42"]) + "){5}(?:" + genregexp(rules["31"]) + "){5})|"
            regexp += "(?:(?:" + genregexp(rules["42"]) + "){6}(?:" + genregexp(rules["31"]) + "){6})|"
            regexp += "(?:(?:" + genregexp(rules["42"]) + "){7}(?:" + genregexp(rules["31"]) + "){7})|"
            regexp += "(?:(?:" + genregexp(rules["42"]) + "){8}(?:" + genregexp(rules["31"]) + "){8}))"
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
