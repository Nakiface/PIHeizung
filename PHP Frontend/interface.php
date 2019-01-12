<?php

#Heizprogramm in temporäre Datei kopieren
$fehler =copy("heizprogramm.xml","temp.xml");

#Temporäre Datei laden
$xml_full = simplexml_load_file("temp.xml");

#Übersetzung in Interface Format

#Benutzer transformieren
$anzahl_benutzer = $xml_full->count();
for($bid = 0; $bid < $anzahl_benutzer; $bid++){
	$xml_full->benutzer[$bid]->benutzer_id[0]=translate_benutzer_id($xml_full->benutzer[$bid]->benutzer_id[0]);
	
	#Programme transformieren
	$anzahl_programme = $xml_full->benutzer[$bid]->count()-1;
	for($pid = 0; $pid < $anzahl_programme; $pid++){
		$xml_full->benutzer[$bid]->programm[$pid]->programmname[0]=translate_programmname($xml_full->benutzer[$bid]->programm[$pid]->programmname[0]);
		$xml_full->benutzer[$bid]->programm[$pid]->aktivierung[0]=translate_aktivierung($xml_full->benutzer[$bid]->programm[$pid]->aktivierung[0]);
		
		#Anweisungen transformieren
		$anzahl_anweisungen = $xml_full->benutzer[$bid]->programm[$pid]->count()-2;
		for ($aid = 0; $aid < $anzahl_anweisungen; $aid++) {
			
			#Bedingungen transformieren
			$anzahl_bedingungen = $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->count();
			for ($bdid = 0; $bdid < $anzahl_bedingungen; $bdid++) {
				$xml_bedingung = $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[$bdid];
				list ($objekt, $typ, $wert) = translate_bedingung ($xml_bedingung);
				$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[$bdid]->objekt[0]=$objekt;
				$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[$bdid]->typ[0]=$typ;
				$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[$bdid]->wert[0]=$wert;
				
				} #Ende Bedingungen
		
			#Wirkungen transformieren
			$anzahl_wirkungen = $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->count();
			for ($wid = 0; $wid < $anzahl_wirkungen; $wid++) {
				$xml_wirkung = $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[$wid];
				list ($art, $id, $typ, $wert) = translate_wirkung ($xml_wirkung);
				$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[$wid]->art[0]=$art;
				$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[$wid]->id[0]=$id;
				$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[$wid]->typ[0]=$typ;
				$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[$wid]->wert[0]=$wert;
				} #Ende Wirkungen
			} #Ende Anweisungen
		} #Ende Programme
	} #Ende Benutzer

	
#XML-Datei Speichern
$handle = fopen("temp.xml", "wb"); 
fwrite($handle, $xml_full->asXML());
fclose($handle);

$fehler =copy("temp.xml", "interface.xml");

#Datei öffnen und hier beenden
header("Location: info.php");
exit();


#Übersetzt benutzer_id
function translate_benutzer_id ($benutzer_id){
    return $benutzer_id;
	}

#Übersetzt programmname
function translate_programmname ($programmname){
    return $programmname;
	}
	
#Übersetzt aktivierung
function translate_aktivierung ($aktivierung){
	# (aktiv) --> 1
	#  ""     --> 0
    if ($aktivierung == "(aktiv)") {$ergebnis = 1;} else {$ergebnis = 0;}
	return $ergebnis;
	}
	
#Übersetzt bedingung
function translate_bedingung ($xml_bd){
		
	switch($xml_bd->objekt[0]){
        # objekt wochentag --> 1
			# wert Mo --> 0
			# wert Di --> 1
			# wert Mi --> 2
			# wert Do --> 3
			# wert Fr --> 4
			# wert Sa --> 5
			# wert So --> 6
		case ("wochentag"): $objekt = 1;
			switch($xml_bd->wert[0]){
				case ("Mo"): $wert = 0; break;
				case ("Di"): $wert = 1; break;
				case ("Mi"): $wert = 2; break;
				case ("Do"): $wert = 3; break;
				case ("Fr"): $wert = 4; break;
				case ("Sa"): $wert = 5; break;
				case ("So"): $wert = 6; break;
				} 
		break;
		
		# objekt uhrzeit --> 2
		# wert (Uhrzeit) --> wert (minuten)
        case ("uhrzeit"): $objekt = 2;  
			$wert = 60*substr($xml_bd->wert[0],0,-3)+substr($xml_bd->wert[0],-2);
		break;   
	
		# objekt stichzeitpunkt --> 3
		# wert (Sekunden seit 1970) --> wert (Sekunden seit 1970)
        case ("stichzeitpunkt"): $objekt = 3;  
			$wert = $xml_bd->wert[0];
		break;
	
		# objekt temperatur --> 4
		# wert (°C) --> wert (°C)
        case ("temperatur"): $objekt = 4;  
			$wert = $xml_bd->wert[0];
		break; 
		} 
	
	# typ gleich        --> 1
	# typ größer        --> 2
	# typ kleiner       --> 3
	# typ größergleich 	--> 4
	# typ kleinergleich --> 5
	
	switch($xml_bd->typ[0]){
		case ("gleich"): $typ = 1; break;
		case ("groesser"): $typ = 2; break;
		case ("kleiner"): $typ = 3; break;
		case ("groessergleich"): $typ = 4; break;
		case ("kleinergleich"): $typ = 5; break;
		} 
	
	return array ($objekt, $typ, $wert);
	}	
	
#Übersetzt wirkung
function translate_wirkung ($xml_wk){
	# art gpio --> 1
		# id 		 --> id
		# typ output --> 1
		# wert 		 --> wert
		
	switch($xml_wk->art[0]){
        case ("gpio"): $art = 1;
			$id=$xml_wk->id[0];
			switch($xml_wk->typ[0]){
				case ("output"): $typ = 1; break;
				} 
			$wert=$xml_wk->wert[0];
		break;
		} 	
	return array ($art, $id, $typ, $wert);
	}		

?>