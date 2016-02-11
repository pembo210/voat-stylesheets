import socket
import sys
from random import randint
import re
import time
import random
#----------------------------------- Settings --------------------------------------#
network = 'irc.goat.chat'
port = 6667
homechan = '#nascar'
irc = socket.socket ( socket.AF_INET, socket.SOCK_STREAM )
irc.connect ( ( network, port ) )
print irc.recv ( 4096 )
irc.send ( 'NICK nascarBot\r\n' )
irc.send ( 'USER nascarBot nascarBot nascarBot :Python IRC\r\n' )
# irc.send ( 'PASS pjmtpjmt\r\n')
#----------------------------------------------------------------------------------#
#     Based on github.com/monoxane/polybot
#---------------------------------- Functions -------------------------------------#

def Send(msg):
    irc.send('PRIVMSG ' + homechan + ' :' + msg +  '\r\n')

def Join(chan):
    irc.send ( 'JOIN ' + chan + '\r\n' )

def Part(chan):
    irc.send ( 'PART ' + chan + '\r\n' )

def NewNick():
    datafile = file('joinlog.txt')
    for line in datafile:
        if nick in line:
            found = True
            break
    return found

#------------------------------------------------------------------------------#
while True:
    action = 'none'
    data = irc.recv ( 4096 )
    print data

    if data.find ( 'Welcome to...' ) != -1:
            Join(homechan)
            irc.send('MODE nascarBot +B')

    if data.find ( 'PING' ) != -1:
            irc.send ( 'PONG ' + data.split() [ 1 ] + '\r\n' )


    #--------------------------- Action check --------------------------------#
    if data.find('#') != -1:
        action = data.split('#')[0]
        action = action.split(' ')[1]

    if data.find('NICK') != -1:
        if data.find('#') == -1:
            action = 'NICK'

    #----------------------------- Actions -----------------------------------#
    if action != 'none':

		if action == 'PRIVMSG':

            # since we dont't have jenni #
			if data.find('v/') != -1:
 				match = re.search('v/(\w*)', data)
				for group in match.groups():
					Send(str('https://voat.co/v/') + group + str(''))

    #----------------------------- Drivers -----------------------------------#
#http://www.nascar.com/en_us/drivers.html
			if data.find('car#1') != -1:
				Send('#1 Jamie McMurray, Chip Ganassi Racing with Felix Sabates')

			if data.find('car#2') != -1:
				Send('#2 Brad Keselowski, Team Penske')

			if data.find('car#3') != -1:
				Send('#3 Austin Dillon, Richard Childress Racing')

			if data.find('car#4') != -1:
				Send('#4 Kevin Harvick, Stewart-Haas Racing')

			if data.find('car#5') != -1:
				Send('#5 Kasey Kahne, Hendrick Motorsports')

			if data.find('car#6') != -1:
				Send('#6 Trevor Bayne, Roush Fenway Racing')

			if data.find('car#7') != -1:
				Send('#7 Regan Smith, Tommy Baldwin Racing')

			if data.find('car#10') != -1:
				Send('#10 Danica Patrick, Stewart-Haas Racing')

			if data.find('car#11') != -1:
				Send('#11 Denny Hamlin, Joe Gibbs Racing')

			if data.find('car#13') != -1:
				Send('#13 Casey Mears, Germain Racing')

			if data.find('car#14') != -1:
				Send('#14 Tony Stewart, Stewart-Haas Racing')

			if data.find('car#15') != -1:
				Send('#15 Clint Bowyer, HScott Motorsports')

			if data.find('car#16') != -1:
				Send('#16 Greg Biffle, Roush Fenway Racing')

			if data.find('car#17') != -1:
				Send('#17 Ricky Stenhouse Jr, Roush Fenway Racing')

			if data.find('car#18') != -1:
				Send('#18 Kyle Busch, Joe Gibbs Racing')

			if data.find('car#19') != -1:
				Send('#19 Carl Edwards, Joe Gibbs Racing')

			if data.find('car#20') != -1:
				Send('#20 Matt Kenseth, Joe Gibbs Racing')

			if data.find('car#21') != -1:
				Send('#21 Ryan Blaney, Wood Brothers Racing')

			if data.find('car#22') != -1:
				Send('#22 Joey Logano, Team Penske')

			if data.find('car#23') != -1:
				Send('#23 David Ragan, Jeb Burton, BK Racing')

			if data.find('car#24') != -1:
				Send('#24 Chase Elliott, Hendrick Motorsports')

			if data.find('car#27') != -1:
				Send('#27 Paul Menard, Richard Childress Racing')

			if data.find('car#31') != -1:
				Send('#31 Ryan Newman, Richard Childress Racing')

			if data.find('car#32') != -1:
				Send('#32 Bobby Labonte or Jeffrey Earnhardt, Go Green Racing')

			if data.find('car#34') != -1:
				Send('#34 Chris Buescher, Front Row Motorsports')

			if data.find('car#38') != -1:
				Send('#38 Landon Cassill, Front Row Motorsports')

			if data.find('car#41') != -1:
				Send('#41 Kurt Busch, Stewart-Haas Racing')

			if data.find('car#42') != -1:
				Send('#42 Kyle Larson, Target Chip Ganassi Racing')

			if data.find('car#43') != -1:
				Send('#43 Aric Almirola, Richard Petty Motorsports')

			if data.find('car#44') != -1:
				Send('#44 Brian Scott, Richard Petty Motorsports')

			if data.find('car#46') != -1:
				Send('#46 Michael Annett, HScott Motorsports')

			if data.find('car#47') != -1:
				Send('#47 AJ Allmendinger, JTG Daugherty Racing')

			if data.find('car#48') != -1:
				Send('#48 Jimmie Johnson, Hendrick Motorsports')

			if data.find('car#78') != -1:
				Send('#78 Martin Truex Jr, Furniture Row Racing')

			if data.find('car#83') != -1:
				Send('#83 Matt DiBenedetto or Michael Waltrip, BK Racing')

			if data.find('car#88') != -1:
				Send('#88 Dale Earnhardt Jr, Hendrick Motorsports')

			if data.find('car#95') != -1:
				Send('#95 Ty Dillon or Michael McDowell, Circle Sport - Leavine Family Racing')

			if data.find('car#98') != -1:
				Send('#98 Cole Whitt, Premium Motorsports')

    #----------------------------- Actions -----------------------------------#
			if data.find('nascarBot, ') != -1:
				x = data.split('#')[1]
				x = x.split('nascarBot, ')[1]
				info = x.split('\t\n\r')
				info[0] = info[0].strip(' \t\n\r')

				if info[0] == 'info':
					Send('Welcome to the irc channel for \00310 https://voat.co/v/nascar\003' )
					Send('Activate the bot by saying "car#88" "car#21" or any other car number.' )

				elif info[0] == 'race':
					Send('vrooooooom ' )

				elif info[0] == 'drivers':
					Send('start you engines' )

				elif info[0] == 'ping':
					Send('pong')

				elif info[0] == 'hi':
					Send('hello')

				elif info[0] == 'version':
					Send('1.0')

				else:
					nick = data.split('!')[0]
					nick = nick.replace(':', ' ')
					nick = nick.replace(' ', '')
					nick = nick.strip(' \t\n\r')
					Send("I'm sorry "+ nick +", I only turn left.")

    if action == 'JOIN':
        open("joinlog.txt", 'a').write(data)
        time.sleep(0.5)
        wb = random.choice(["Start your engines", "welcome to the track"])
        nick = data.split('!')[0]
        nick = nick.replace(':', ' ')
        nick = nick.replace(' ', '')
        nick = nick.strip(' \t\n\r')
        datafile = file('joinlog.txt')
        for line in datafile:
            if nick in line:
                Send(nick + 'is at the track')
                break
            else:
                Send(wb + ' ' + nick)
                break
