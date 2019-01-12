#!/usr/bin/env python3
import xmleinlesen
import bedingung_pruefen
import wirkung_ausfuehren

#xml einlesen
root=xmleinlesen.einlesen()

#Zaehlen Wieviele Programme sind Aktiv?
AnzProgramme = 0
for child in root[0]:
    AnzProgramme=AnzProgramme+1
AnzProgramme=AnzProgramme-1 #-1 da Benutzer ID auch child von root[0] ist
#print('Anzahl Programme: ',AnzProgramme)

#Fuer alle Programme wird nun gleich weiterverfahren
i = 0
while (i < AnzProgramme):
    i=i+1
    vergleicher=root[0][i][1].text
    vergleich = int(vergleicher) #die string wird in int umgewandelt fuer den Vergleich
    
    #Ueberpruefen ob das Programm i aktiv ist
    if vergleich == 1:
        negativwert = 0 #Prueft, ob mindestens eine Anweisung erfuellt ist
        #Wieviele Anweisungen gibt es fuer dieses Programm
        AnzAnweisung = 0
        for child in root[0][i]:
            AnzAnweisung=AnzAnweisung+1
        AnzAnweisung=AnzAnweisung-2 #-2 da Programmname und  aktivierung auch child von programm[0] ist
        #print('Anzahl Anweisungen fuer Programm ',i,' : ',AnzAnweisung)
        #print('Programm' ,i,' ist aktiv')
        
        #Fuer alle Anweisungen wird nun gleich weiterverfahren
        j = 1
        while (j < AnzAnweisung+1): #da wir die erste anweisungen erst bei [2] haben
            j=j+1
            
            #Wieviele Bedingungen haben wir in dieser Anweisung
            AnzBedingung = 0
            for child in root[0][i][j][0]:
                AnzBedingung=AnzBedingung+1
            #print('Anzahl Bedingung fuer Programm ',i,' und Anweisung ',j-1,' : ',AnzBedingung)
            
            #Fuer jede Bedingung wird nun wie gleich weiterverfahren
            n=0
            aktiv=1
            while (n<AnzBedingung):
                objekt = root[0][i][j][0][n][0].text #der Wert wird objekt uebergeben
                objekt = int(objekt)
                typ = root[0][i][j][0][n][1].text #Wert wird typ uebergeben
                typ = int(typ)
                wert = root[0][i][j][0][n][2].text #Wert wird wert uebergeben
                wert = int(wert)
                print(objekt, typ, wert)
                aktivieren=bedingung_pruefen.bd_check(objekt,typ,wert)
                aktiv=aktivieren*aktiv
                n=n+1
                print('fuer Programm ',i,' und Anweisung ',j-1,' und Bedingung ',n,' :')
                print('akitv:', aktivieren)
                
            #Wirkung fuer jede Anweisung wenn Anweisung aktiv
            print('fuer Programm ',i,' und Anweisung ',j-1,' Aktiv? :',aktiv)
               
            #Anzahl Wirkungen        
            AnzWirkungen = 0
            for child in root[0][i][j][1]:
                AnzWirkungen=AnzWirkungen+1
            #print('Anzahl Wirkung fuer Programm ',i,' und Anweisung ',j-1,' : ',AnzWirkungen)
            
            #fuer jede Wirkung wird der GPIO gesteuert
            m=0
            if aktiv == 1:
                while (m < AnzWirkungen):
                    art = root[0][i][j][1][m][0].text #Wert wird art uebergeben
                    art = int(art)
                    pinnr = root[0][i][j][1][m][1].text #Wert wird pinnr uebergeben
                    pinnr = int(pinnr)
                    typ = root[0][i][j][1][m][2].text #Wert wird typ uebergeben
                    typ = int(typ)
                    wert = root[0][i][j][1][m][3].text #Wert wird wert uebergeben
                    wert = int(wert)
                    wirkung_ausfuehren.wk_exe(art, pinnr, typ, wert)
                    m=m+1
                    negativwert=negativwert+1
       
        if negativwert < 1:
            art = int(root[0][i][2][1][0][0].text) #Wert wird art uebergeben
            pinnr = int(root[0][i][2][1][0][1].text) #Wert wird pinnr uebergeben
            typ = int(root[0][i][2][1][0][2].text) #Wert wird typ uebergeben
            wert = 1
            wirkung_ausfuehren.wk_exe(art, pinnr, typ, wert)     
                      
    #Programm i ist inaktiv
    else:
        print('Programm ',i,' ist inaktiv')
    #print ('Anzahl Programme: ',i)
    
    







    







