#!/usr/bin/env python3
#Eine Wirkung, z.B. Pin schalten, wird ausgefuehrt

#Initialisierung

def wk_exe(art, pinnr, typ, wert):
    # art 1 --> GPIO
    if art == 1:
        import RPi.GPIO as GPIO
        GPIO.setmode(GPIO.BOARD)
        
        # typ 1 --> Output
        if typ == 1:
            GPIO.setup(pinnr, GPIO.OUT)
            GPIO.output(pinnr, wert)
            print ('GPIO Richtung: Out')
        
        # typ 2 --> Input    
        elif typ == 2:
            GPIO.setup(pinnr, GPIO.IN)
            print ('GPIO Richtung: In')
        
    print ('Setting Pin: ', pinnr)
    print ('PinValue: ', wert)

#wk_exe(1,3,1,0)
