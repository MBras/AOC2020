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
                # excisting allergen, remove all ingredients from the allergen list not in current ingredients
                for a in allergens[allergen]:
                    print "Checking allergen '" + allergen + "' for " + a + " in " 
                    print ingredientinput
                    if not a in ingredientinput:
                        ta.remove(a)
                        print "Removing allergen '" + a + "' from " + allergen
                allergens[allergen] = ta[:]
            else:
                # new allergen
                print "New allergen '" + allergen + "' possibly: " 
                print ingredientinput
                allergens[allergen] = ingredientinput

print "Ingredients:"
print ingredients
print "Allergens:"
print allergens

# check for all igredients if they appear in the allergens
for i in ingredients[:-1]:
    for a in allergens:
        print "Looking for " + i + " in "
        print allergens[a]
        if i in allergens[a]:
            # found it, remove it
            ingredients.remove(i)
            print "Founds " + i
            break

print "Final ingredients:"
print ingredients
print "Part 1: " + str(len(ingredients))


# ===========================[ PART II ]===========================
finalallergens = {}

# process all allergens
while len(allergens) > 0:
    for a in allergens:
        if len(allergens[a]) == 1:
            # found a unique ingredient
            print "Matched '" + a + "' to '" + allergens[a][0] + "'"

            # move the allergen to the finalallergens
            atr = allergens[a][0] # allergen to remove
            finalallergens[a] = atr
            del allergens[a]
            
            # remove it from all other allergens
            for a2 in allergens:
                print "Removing " + atr + " from: "
                print allergens[a2]
                try:
                    allergens[a2].remove(atr)
                except ValueError:
                    print atr + " not in the list"
            break

# sort allergens by key
part2 = []
for a in sorted(finalallergens):
    part2.append(finalallergens[a])

print "Part 2: " + ",".join(part2)

