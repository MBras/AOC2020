import time

data = list("389125467")
data = list("158937462")

data = [int(i) for i in data] # convert to a list of numbers

#Represents the node of list.    
class Cup:    
    def __init__(self,data):    
        self.data = data;    
        self.next = None;    
     
class CupCircle:    
    #Declaring head and tail pointer as null.    
    def __init__(self):    
        self.head = Cup(None)
        self.tail = Cup(None)
        self.maxvalue = 0
        self.head.next = self.tail
        self.tail.next = self.head
        self.searchIndex = {}
        
    #This function will add the new cup at the end of the list.    
    def add(self,data):    
        newCup = Cup(data);    
        #Checks if the list is empty.    
        if self.head.data is None:    
            #If list is empty, both head and tail would point to new cup.    
            self.head = newCup;    
            self.tail = newCup;    
            newCup.next = self.head;    
        else:    
            #tail will point to new cup.    
            self.tail.next = newCup;    
            #New node will become new tail.    
            self.tail = newCup;    
            #Since, it is circular linked list tail will point to head.    
            self.tail.next = self.head;    
        if data > self.maxvalue:
            self.maxvalue = data
        # store pointers for quick searching
        self.searchIndex[data] = newCup
    
    #Displays all the nodes in the list    
    def display(self):    
        current = self.head;    
        if self.head is None:    
            print("List is empty");    
            return;    
        else:    
            print "cups:",    
            #Prints each node by incrementing pointer.    
            print "(" + str(current.data) + ")",    
            while current.next != self.head:    
                current = current.next;    
                print current.data,
        print

    def find(self, needle):
        return self.searchIndex[needle]

    def pickup(self):
        # determine destionation
        destination = self.head.data - 1
        while 1:
            if destination <= 0:
                destination = self.maxvalue
            if destination == self.head.next.data or destination == self.head.next.next.data or destination == self.head.next.next.next.data:
                destination -= 1
            else:
                break

        # show picked up cups
        #print "pick up:",
        #print str(self.head.next.data) + ",",
        #print str(self.head.next.next.data) + ",",
        #print self.head.next.next.next.data
                
        # determine destination
        #print "destionation: " + str(destination)
        destinationcup = self.find(destination)
        # and place the picked up cups there
        backupcuppointer = self.head.next.next.next.next    # backup the pointer to the first cup after the picked up ones
        self.head.next.next.next.next = destinationcup.next # make the last icked up cup point to destination + 1
        destinationcup.next = self.head.next                # update destination to point to the first of the picked up cup

        # reattach circle
        self.head.next = backupcuppointer

        #print
        # set head to the next cup
        self.head = self.head.next

    def move(self, move):
        #print "-- move " + str(move + 1) + " --"
        #self.display()
        self.pickup()

    def final(self):
        print "-- final --"
        self.display()
        print "Part 1:",
        answer = self.find(1)
        sum = 0
        while answer.next.data <> 1:
            answer = answer.next
            sum = 10 * sum + answer.data
        print sum

cups = CupCircle()
for d in data:
    cups.add(d)

#fill up cups with followup numbers
for i in range(cups.maxvalue + 1, 1000000 + 1):
    cups.add(i)

moves = 10000000

start = time.time()
for i in range(moves):
    cups.move(i)
    #cup1 = cups.find(1)
    #print "Move " + str(i + 1) + " - Part 2: " + str(cup1.next.data) + " x " + str(cup1.next.next.data) + " = " + str(cup1.next.data * cup1.next.next.data)
    if (i % 1000) == 0:
        print "Move " + str(i + 1) + " duration " + str(time.time() - start)
        start = time.time()
#cups.display()
#cups.final()
cup1 = cups.find(1)
print "Move " + str(i + 1) + " - Part 2: " + str(cup1.next.data) + " x " + str(cup1.next.next.data) + " = " + str(cup1.next.data * cup1.next.next.data)
