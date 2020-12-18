import re

def calc(tokens):
    # show tokens
    #print tokens

    localtokens = []
    search = 0
    
    # start scanning the string from left to right
    for token in tokens:
        # if we encounter an opening parentheses
        if token == "(" and not(search): # start searching for the macthing closing bracket
            search = 1
            ptokens = []
            pc = 1 # parantheses counter
        elif token == "(":
            # found another paranthese, increase pc
            pc += 1
            ptokens.append(token)
        elif token == ")":
            pc -= 1
            if pc == 0:
                # found the final parantheses, call calc for the subset
                search = 0
                localtokens.append(calc(ptokens))
            else:
                # not the final closing bracket, continue
                ptokens.append(token)
        elif search:
            ptokens.append(token)
        else:
            localtokens.append(token)

    # all tokens are now cleaned up from paranthese, so perform the actual calculations
 
    # start with all multiplications
    done = 0
    while 1:
        finaltokens = []
        # find first multiplication
        try:
           first = localtokens.index("+")
        except ValueError:
            break

        # perform the multiplication and slice the begin and end of the tokens with the outcome in the middle
        sum = int(localtokens[first - 1]) + int(localtokens[first + 1])
        finaltokens = localtokens[0:max(first - 1, 0)] + [sum] + localtokens[first + 2:]
        
        # copy finaltokens to localtokens to go again
        localtokens = finaltokens

    # next perform all additions
    sum = int(localtokens[0])
    for x in range(2, len(localtokens), 2):
        sum *= int(localtokens[x])
    
    return sum

def tokenize(str):
    # parse the string into tokens
    return re.findall('(\d+|\+|\*|\(|\))', str)
    
print "2 * 3 + (4 * 5) = " + str(calc(tokenize("2 * 3 + (4 * 5)")))
print "5 + (8 * 3 + 9 + 3 * 4 * 3) = " + str(calc(tokenize("5 + (8 * 3 + 9 + 3 * 4 * 3)")))
print "((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2 = " + str(calc(tokenize("((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2")))

with open("input", "r") as input:
    lines = input.readlines()

sum = 0;
for line in lines:
    sum += calc(tokenize(line))

print "Part 2: " + str(sum)
