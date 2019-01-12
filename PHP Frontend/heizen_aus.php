<?php

#Programme laden
$xml_full = simplexml_load_file("heizprogramm.xml");
$bid = 0;

#Daten aus Formular auslesen
$pid = $_POST[pid]+0;
$stunden = $_POST[stunden];

#Stichzeitpunkt bestimmen
$stichzeitpunkt = time() + 60*60*$stunden;

#Alle bisherigen Stichzeitpunkte aktualisieren
$anzahl_anweisung = $xml_full->benutzer[$bid]->programm[$pid]->count()-2;
for($aid = 0; $aid < $anzahl_anweisung; $aid++){
	$anzahl_bedingungen = $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->count();
	for($bdid = 0; $bdid < $anzahl_bedingungen; $bdid++){
    if ($xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[$bdid]->objekt[0] == 'stichzeitpunkt') 
		{
        $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[$bdid]->wert[0] = $stichzeitpunkt;
		}
	}
}

#Temperatur bis Stichzeitpunkt auf Soll-Temperatur setzen
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[1]->wenn[0]->bedingung[1]->wert[0]=$xml_full->benutzer[$bid]->programm[$pid]->anweisung[0]->wenn[0]->bedingung[0]->wert[0];

#XML-Datei Speichern
$handle = fopen("heizprogramm.xml", "wb"); 
fwrite($handle, $xml_full->asXML());
fclose($handle);

echo "
    Daten gespeichert!
    <br>
    <form action=\"formular_verarbeiten.php\" method=\"post\">
    <input type=\"button\" value=\"Weiter\" onclick=\"window.location.href='interface.php'\" /></form>
    ";

?>