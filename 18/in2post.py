import re

def calcpost(tokens):
    print "Calculating "
    print tokens

    stack = []

    for token in tokens:
        if token == "+":
            stack.append(stack.pop() + stack.pop())
        elif token == "*":
            stack.append(stack.pop() * stack.pop())
        else:
            stack.append(token)
    
    return stack.pop()

def in2post(tokens):
    stack = []
    postfix = []
    prio = []

    prio = {"+": 2, "*": 1}

    for token in tokens:
        if token == "(":
            stack.append("(")
        elif token == ")":
            # pop tokens from the stack until an opening bracket is found
            while 1:
                if stack[-1] == "(":
                    stack.pop()
                    break
                else:
                    postfix.append(stack.pop())
        elif token == "+" or token == "*":
            # check prio against stack top 
            if len(stack) > 0 and stack[-1] != "(" and prio[token] > prio[stack[-1]]:
                stack.append(token)
            else:
                while 1:
                    # pop tokens until a higher prio token is encountered
                    if len(stack) > 0 and stack[-1] != "(" and prio[token] <= prio[stack[-1]]:
                        postfix.append(stack.pop())
                    else:
                        break
                stack.append(token)
        else:
            postfix.append(int(token))

    while len(stack) > 0:
        postfix.append(stack.pop())
    
    return postfix

def tokenize(str):
    # parse the string into tokens
    tokens = re.findall('(\d+|\+|\*|\(|\))', str)
    print "Tokens at start:"
    print tokens
    return tokens
    
tokens = tokenize("((2 + 4 * 9) * (6 + 9 * 8 + 6) + 6) + 2 + 4 * 2")
tokens = in2post(tokens)
print calcpost(tokens)

print calcpost(in2post(tokenize("5 * 9 * (7 * 3 * 3 + 9 * 3 + (8 + 6 * 4))")))
