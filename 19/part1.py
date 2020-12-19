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
print rules

print "Puzzles:"
print puzzles

def genregexp(rule):
    regexp = ""
    matches = re.findall("(\S+|\|)(?: )*", rule)
    # check for "|" in matches to include braces
    if "|" in matches:
        regexp += "(?:"
    for match in matches:
        try:
            #print "Found it, now looking for " + rules[match]
            regexp += genregexp(rules[match])
        except KeyError:
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
print "Part 1: " + str(count)
