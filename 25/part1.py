div = 20201227

card_sn = 7

door_val = 1
card_val = 1
card_pk = 18499292
door_pk = 8790390

cardcounter = 0
while 1:
    cardcounter += 1
    card_val = (card_val * card_sn) % div
    if card_val == card_pk:
        break

doorcounter = 0
while 1:
    doorcounter += 1
    door_val = (door_val * card_sn) % div
    if door_val == door_pk:
        break

door_val = 1
for i in range(cardcounter):
    door_val = (door_val * door_pk) % div

print door_val

card_val = 1
for i in range(doorcounter):
    card_val = (card_val * card_pk) % div

print card_val
