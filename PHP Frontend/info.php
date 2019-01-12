<?php

#Liest die XML-Datei aus
$xml_full = simplexml_load_file("heizprogramm.xml");
$xml = $xml_full->benutzer[0];

alle_programme($xml,0);

function alle_programme ($xmlobjekt, $benutzer) {
	$anzahl_programme = $xmlobjekt->count()-1;
	echo"<h1>Hallo $xmlobjekt->benutzer_id!</h1>
		<form>
		Ihre Programmübersicht:<br>";
		for($pid = 0; $pid < $anzahl_programme; $pid++){
				$programmname = $xmlobjekt->programm[$pid]->programmname[0];
				$aktivierung = $xmlobjekt->programm[$pid]->aktivierung[0];
				echo "<input type=\"radio\" name=\"Programm\" value=$pid> $programmname &nbsp $aktivierung<br>";
            }	  
		echo"<input type=\"submit\" name=\"button\" value=\"aktivieren\" formaction=\"programm_aktivieren.php\" formmethod=\"post\">
		<input type=\"submit\" name=\"button\" value=\"bearbeiten\" formaction=\"programm_anzeigen.php\" formmethod=\"post\"><br>
		<input type=\"submit\" name=\"button\" value=\"Heizung an / aus\" formaction=\"heizen_an_aus.php\" formmethod=\"post\"></form>";		
	}
?>