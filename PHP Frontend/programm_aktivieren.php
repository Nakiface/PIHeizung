<?php

#Programme laden
$xml_full = simplexml_load_file("heizprogramm.xml");
$bid = 0;

#Anzahl Programme auszählen
$anzahl_programme = $xml_full->benutzer[$bid]->count()-1;

#Alle Aktivierungen löschen
for($pid = 0; $pid < $anzahl_programme; $pid++){    
    $xml_full->benutzer[$bid]->programm[$pid]->aktivierung[0]="";
	}	

#Programm aktivieren
$pid =0 + $_POST[Programm];
$xml_full->benutzer[$bid]->programm[$pid]->aktivierung[0]="(aktiv)";

#XML-Datei Speichern
$handle = fopen("heizprogramm.xml", "wb"); 
fwrite($handle, $xml_full->asXML());
fclose($handle);

#Datei öffnen und hier beenden
header("Location: interface.php");
exit();

?>