import re

lines = open("input.1").read()
lines = open("input.2").read()
lines = lines.splitlines()

ingredients = []
allergens = {}

for line in lines:
    print "Parse the line"
    m = re.search("([a-z ]*)(?:\(([a-z, ]*)\))*", line)
    print "Ingredients: "
    ingredientinput = m.group(1).split()
    for ingredient in ingredientinput:
        print "Adding: " + ingredient
        ingredients.append(ingredient)

    if len(m.group(2)):
        print "Allergens: " 
        allergeninput = m.group(2)[9:].replace(" ", "").split(",")
        for allergen in allergeninput:
            # check if the allergen already exists
            if allergen in allergens:
                ta = allergens[allergen][:] # temp allergen store
                print ta
                # excisting key, remove all ingredients from the allergen list nog in current ingredients
                for a in allergens[allergen]:
                    print "Checking allergen '" + allergen + "' for " + a + " in " 
                    print ingredientinput
                    if not a in ingredientinput:
                        ta.remove(a)
                        print "Removing allergen '" + a + "' from " + allergen
                allergens[allergen] = ta[:]
            else:
                # new key
                print "New allergen '" + allergen + "' possibly: " 
                print ingredientinput
                allergens[allergen] = ingredientinput

print "Ingredients:"
print ingredients
print "Allergens:"
print allergens

# check for all igredients if they appear in the allergens
newingredients = ingredients[:]
for i in ingredients:
    for a in allergens:
        print "Looking for " + i + " in "
        print allergens[a]
        if i in allergens[a]:
            # found it, remove it
            newingredients.remove(i)
            print "Founds " + i
            break

print "Final ingredients:"
print newingredients
print "Part 1: " + str(len(newingredients))

