<?php

#Programm laden
$xml_full = simplexml_load_file("heizprogramm.xml");
$bid = 0;
$pid = 0 + $_POST[pid];

#Bestehende XML-Werte mit Formularwerten überschreiben
$xml_full->benutzer[$bid]->programm[$pid]->programmname[0]=$_POST[titel];
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[0]->wenn[0]->bedingung[0]->wert[0]=$_POST[t_min];
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[1]->wenn[0]->bedingung[1]->wert[0]=$_POST[t_soll];
$anzahl_anweisung = $xml_full->benutzer[$bid]->programm[$pid]->count()-2;
for($aid = 2; $aid < $anzahl_anweisung; $aid++){    
	$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[1]->wert[0]=$_POST[t_soll];
	$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[2]->wert[0]=$_POST[100000*($bid+1)+10000*$pid+1000*($aid+1)+100*0+10*2+3];
    $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[3]->wert[0]=$_POST[100000*($bid+1)+10000*$pid+1000*($aid+1)+100*0+10*3+3];
    $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[4]->wert[0]=$_POST[100000*($bid+1)+10000*$pid+1000*($aid+1)+100*0+10*4+3];
    $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[5]->wert[0]=$_POST[100000*($bid+1)+10000*$pid+1000*($aid+1)+100*0+10*5+3];
}

#Neue XML-Anweisung erzeugen und mit Formularwerten beschreiben
$xml_full->benutzer[$bid]->programm[$pid]->addChild('anweisung');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->addChild('wenn');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->addChild('bedingung');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[0]->addChild('objekt','stichzeitpunkt');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[0]->addChild('typ','groessergleich');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[0]->addChild('wert',$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid-1]->wenn[0]->bedingung[0]->wert[0]);
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->addChild('bedingung');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[1]->addChild('objekt','temperatur');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[1]->addChild('typ','kleiner');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[1]->addChild('wert',$_POST[t_soll]);
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->addChild('bedingung');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[2]->addChild('objekt','wochentag');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[2]->addChild('typ','groessergleich');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[2]->addChild('wert',$_POST[100000*($bid+1)+10000*$pid+1000*($aid+1)+100*0+10*2+3]);
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->addChild('bedingung');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[3]->addChild('objekt','wochentag');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[3]->addChild('typ','kleinergleich');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[3]->addChild('wert',$_POST[100000*($bid+1)+10000*$pid+1000*($aid+1)+100*0+10*3+3]);
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->addChild('bedingung');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[4]->addChild('objekt','uhrzeit');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[4]->addChild('typ','groessergleich');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[4]->addChild('wert',$_POST[100000*($bid+1)+10000*$pid+1000*($aid+1)+100*0+10*4+3]);
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->addChild('bedingung');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[5]->addChild('objekt','uhrzeit');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[5]->addChild('typ','kleinergleich');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[5]->addChild('wert',$_POST[100000*($bid+1)+10000*$pid+1000*($aid+1)+100*0+10*5+3]);
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->addChild('dann');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->addChild('wirkung');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[0]->addChild('art', 'gpio');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[0]->addChild('id', '3');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[0]->addChild('typ', 'output');
$xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->dann[0]->wirkung[0]->addChild('wert', '0');

#Unvollständige XML-Datensätze löschen
$anzahl_anweisung = $xml_full->benutzer[$bid]->programm[$pid]->count()-2;
for($aid = 2; $aid < $anzahl_anweisung; $aid++){
    if ($xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[4]->wert[0] == '' 
    or $xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]->wenn[0]->bedingung[5]->wert[0]=='' ){
        unset($xml_full->benutzer[$bid]->programm[$pid]->anweisung[$aid]);
        $aid = $aid-1;
        $anzahl_anweisung=$anzahl_anweisung-1;
    } 
}

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
    
    
#ausgabe_id(654321, "pid");
function ausgabe_id ($id, $id_typ){
    switch($id_typ)
    {
        case ("pid"): $index=10000; break;
        case ("aid"): $index=1000;  break;
        case ("bid"): $index=10;    break;
    }
    $id_kurz = truncate($id/$index, 0)-truncate($id/($index*10), 0)*10;
    return $id_kurz;
}

function truncate ($num, $digits = 0) {
    //provide the real number, and the number of digits right of the decimal you want to keep.
    $shift = pow(10, $digits);
    return ((floor($num * $shift)) / $shift);
}  

?>