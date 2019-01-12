<?php

#Programme laden
$xml_full = simplexml_load_file("heizprogramm.xml");
$bid = 0;

#Anzahl Programme auszählen
$anzahl_programme = $xml_full->benutzer[$bid]->count()-1;

#Aktives Programm ermitteln
$aktiv_pid = -1;
for($pid = 0; $pid < $anzahl_programme; $pid++){    
    if ($xml_full->benutzer[$bid]->programm[$pid]->aktivierung[0]=="(aktiv)") 
		{$aktiv_pid = $pid;}
	}
	
if ($aktiv_pid >= 0) {
	#Ausgabe des Programmtitels
	$prg_titel = $xml_full->benutzer[$bid]->programm[$aktiv_pid]->programmname[0];
	echo "<h3>Programm: $prg_titel </h3>";
	
	#Auswahlformular
	echo"<form>
			<input type=\"hidden\" name=\"pid\" value=$aktiv_pid><br>
			Heizen an / aus f&uuml;r die n&auml;chsten <br>
			<input type=\"text\" name=\"stunden\" style=\"width:30px;\" value=5> Stunden <br>
			<input type=\"submit\" name=\"button\" value=\"Heizen an\" formaction=\"heizen_an.php\" formmethod=\"post\">
			<input type=\"submit\" name=\"button\" value=\"Heizen aus\" formaction=\"heizen_aus.php\" formmethod=\"post\"><br>
			<input type=\"button\" value=\"Abbrechen\" onclick=\"window.location.href='info.php'\">
		</form>";
	}
	#Ausgabe, falls kein Programm aktiv ist (eigentlich nicht möglich
	else {echo "Achtung: Um diese Funktion zu nutzen, muss ein Programm aktiviert sein.<br>";
		echo"<form>
			<input type=\"button\" value=\"Abbrechen\" onclick=\"window.location.href='info.php'\">
		</form>";
		}

?>