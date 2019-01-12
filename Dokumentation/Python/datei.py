# erstellt die interfaces Datei
def Datei(name, pw):
    datei = open("/home/bernhard/Dokumente/Phyton/interfaces", "w")
    datei.write("auto lo \n")
    datei.write("iface lo inet loopback\n\n")
    datei.write("iface eth0 inet dhcp\n")
    datei.write("iface default inet dhcp\n\n")
    datei.write("auto wlan0\n")
    datei.write("iface wlan0 inet dhcp\n")
    datei.write("wpa-ssid ")
    datei.write(name)
    datei.write("\n")
    datei.write("wpa-psk ")
    datei.write(pw)
    datei.close()

#Hauptmenue
name = input("Geben Sie ihren Wlan Namen ein: ")
pw = input("Geben Sie ihr Wlan Passwortein: ")
print(name ,pw)
Datei(name, pw)
