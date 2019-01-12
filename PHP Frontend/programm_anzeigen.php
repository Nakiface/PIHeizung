<?php

#Liest die XML-Datei aus
$xml_full = simplexml_load_file("heizprogramm.xml");
$xml = $xml_full->benutzer[0];

#Programm anzeigen
$prg = 0 + $_POST[Programm];
anzeige_programm($xml,0,$prg);

function anzeige_programm ($xmlobjekt, $benutzer, $pid) {
    #gibt das vollständige Formular eines Programms der Zeitschaltuhr an
    $titel = $xmlobjekt->programm[$pid]->programmname[0];
	$t_soll = $xmlobjekt->programm[$pid]->anweisung[2]->wenn[0]->bedingung[1]->wert[0];
	$t_min = $xmlobjekt->programm[$pid]->anweisung[0]->wenn[0]->bedingung[0]->wert[0];
    echo "<form action=\"formular_verarbeiten.php\" method=\"post\">
            Programm:  <input type=\"text\" name=\"titel\" value=$titel><br>
			Soll-Heiztemperatur in °C:  <input type=\"text\" name=\"t_soll\" style=\"width:45px;\" value=$t_soll>
			Minimaltemperatur in °C:  <input type=\"text\" name=\"t_min\" style=\"width:45px;\" value=$t_min>";
			#Verstecktes Feld für die Programmnummer
			echo "<input type=\"hidden\" name=\"pid\" value=$pid><br>";
            $anzahl_anweisung = $xmlobjekt->programm[$pid]->count()-2;
            for($aid = 2; $aid < $anzahl_anweisung; $aid++){
                  echo "Heizen von ";
                  dropdown_tag($xmlobjekt,$benutzer,$pid,$aid,2);
                  echo " bis ";
                  dropdown_tag($xmlobjekt,$benutzer,$pid,$aid,3);
                  $h1 = $xmlobjekt->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[4]->wert[0];
                  $h2 = $xmlobjekt->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[5]->wert[0];
                  $index1 = 100000*($benutzer+1)+10000*$pid+1000*($aid+1)+100*0+10*4+3;
                  $index2 = 100000*($benutzer+1)+10000*$pid+1000*($aid+1)+100*0+10*5+3;
                  echo " von <input type=\"text\" name=$index1 style=\"width:65px;\" value=$h1>
                  bis <input type=\"text\" name=$index2 style=\"width:65px;\" value=$h2> Uhr<br>";
            }
            #Zusätzliche Anweisung als Eingabemaske
            echo "Heizen von ";
            dropdown_tag($xmlobjekt,$benutzer,$pid,$aid,0);
            echo " bis ";
            dropdown_tag($xmlobjekt,$benutzer,$pid,$aid,1);
            $index1 = 100000*($benutzer+1)+10000*$pid+1000*($aid+1)+100*0+10*4+3;
            $index2 = 100000*($benutzer+1)+10000*$pid+1000*($aid+1)+100*0+10*5+3;
            echo " von <input type=\"text\" name=$index1 style=\"width:65px;\">
            bis <input type=\"text\" name=$index2 style=\"width:65px;\"> Uhr<br>";
	#Buttons
    echo "<input type=\"button\" value=\"Abbrechen\" onclick=\"window.location.href='info.php'\">
    <input type=\"submit\" name=\"Button\" value=\"Speichern\"><br>
	</form>";    
}

function dropdown_tag ($xmlobjekt, $benutzer, $programmnr, $anweisungsnr, $tagtyp){
# gibt ein vorselektiertes DropDown-Feld eines Tages innerhalb einer Form aus.

    #Liest den Wert des Tages aus
    $tagwert=$xmlobjekt->programm[$programmnr]->anweisung[$anweisungsnr]->wenn[0]->bedingung[$tagtyp]->wert[0];
    $index=100000*($benutzer+1)+10000*$programmnr+1000*($anweisungsnr+1)+100*0+10*$tagtyp+3;
    echo "<select name=$index style=\"width:65px;\">";
    if (strpos($tagwert,"Mo") !== false) {echo "<option selected>Mo</option>";} else {echo "<option>Mo</option>";}
    if (strpos($tagwert,"Di") !== false) {echo "<option selected>Di</option>";} else {echo "<option>Di</option>";}
    if (strpos($tagwert,"Mi") !== false) {echo "<option selected>Mi</option>";} else {echo "<option>Mi</option>";}
    if (strpos($tagwert,"Do") !== false) {echo "<option selected>Do</option>";} else {echo "<option>Do</option>";}
    if (strpos($tagwert,"Fr") !== false) {echo "<option selected>Fr</option>";} else {echo "<option>Fr</option>";}
    if (strpos($tagwert,"Sa") !== false) {echo "<option selected>Sa</option>";} else {echo "<option>Sa</option>";}
    if (strpos($tagwert,"So") !== false) {echo "<option selected>So</option>";} else {echo "<option>So</option>";}
    echo "</select>";
}
?>