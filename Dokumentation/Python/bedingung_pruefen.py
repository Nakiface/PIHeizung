#!/usr/bin/env python3
#Ist die Bedingung erfuellt, wird 1 ausgegeben ansonsten 0

import time
import templesen

#Initialisierung
wochentag = time.localtime()[6]
print('wochentag: ',wochentag)
uhrzeit = time.localtime()[3]*60+time.localtime()[4]
aktueller_zeitpunkt = time.time()


def bd_check(objekt, typ, wert):
    ergebnis = 0
    # objekt 1 -> Wochentag
    if objekt == 1:
        # typ 1 -> ==
        if typ == 1:
            if wochentag == wert:
                ergebnis=1
        # typ 2 ->  >
        elif typ == 2:
            if wochentag > wert:
                ergebnis=1
        # typ 3 ->  <
        elif typ == 3:
            if wochentag < wert:
                ergebnis=1
        # typ 4 -> >=
        elif typ == 4:
            if wochentag >= wert:
                ergebnis=1
        # typ 5 -> <=
        elif typ == 5:
            if wochentag <= wert:
                ergebnis=1
                
    # objekt 2 -> Uhrzeit
    elif objekt == 2:
        # typ 1 -> ==
        if typ == 1:
            if uhrzeit == wert:
                ergebnis=1
        # typ 2 ->  >
        elif typ == 2:
            if uhrzeit > wert:
                ergebnis=1
        # typ 3 ->  <
        elif typ == 3:
            if uhrzeit < wert:
                ergebnis=1
        # typ 4 -> >=
        elif typ == 4:
            if uhrzeit >= wert:
                ergebnis=1
        # typ 5 -> <=
        elif typ == 5:
            if uhrzeit <= wert:
                ergebnis=1

    # objekt 3 -> Stichzeit
    elif objekt == 3:
        # typ 1 ->  ==
        if typ == 1:
            if aktueller_zeitpunkt == wert:
                ergebnis=1
        # typ 2 ->  >
        elif typ == 2:
            if aktueller_zeitpunkt > wert:
                ergebnis=1
        # typ 3 ->  <
        elif typ == 3:
            if aktueller_zeitpunkt < wert:
                ergebnis=1
        # typ 4 -> >=
        elif typ == 4:
            if aktueller_zeitpunkt >= wert:
                ergebnis=1
        # typ 5 -> <=
        elif typ == 5:
            if aktueller_zeitpunkt <= wert:
                ergebnis=1
    
    # objekt 4 -> Temperatur-Dummi
    elif objekt == 4:
        #einlesen der Temperatur
        temperatur=templesen.tempeinlesen
        # typ 1 ->  ==
        if typ == 1:
            if temperatur == wert:
                ergebnis=1
        # typ 2 ->  >
        elif typ == 2:
            if temperatur > wert:
                ergebnis=1
        # typ 3 ->  <
        elif typ == 3:
            if temperatur < wert:
                ergebnis=1
        # typ 4 -> >=
        elif typ == 4:
            if temperatur >= wert:
                ergebnis=1
        # typ 5 -> <=
        elif typ == 5:
            if temperatur <= wert:
                ergebnis=1
        
    return ergebnis
 

#print ('Wochentag: ',wochentag, ' Uhrzeit: ',uhrzeit)
#print (bd_check (2,4,888))
