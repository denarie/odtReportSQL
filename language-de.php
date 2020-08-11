<?php
//  ---- odtphp
   $Translation['template not found'] = 'FEHLER: Die Template Datei %s konnte nicht gefunden werden!';
   $Translation['picture not found'] = 'FEHLER: Das Template enthält keine Bilder!';
   $Translation['file picture not found'] = 'FEHLER: Bilddatei konnte nicht gefunden werden [%s]!';
   $Translation['nested exception'] = 'Eltern-Liste f&uuml;r %s darf nicht leer sein';
   $Translation['none result'] = '<BR> FEHLER beim Erstellen des Dokuments! <br>';
   $Translation['original author'] = 'Der/die Autor*in';  // TODO, update this


//  ----  odtReportSQL	(on long HTML, cut lines at TAG attributes)
  $Translation['missed ID']='FEHLER in odtReportSQL.doReport(): required $_POST/$_GET[ID] not defined!'; 
  $Translation['foreach key1 without values'] = '<b>FEHLER: Kann kein Dokument erstellen!<br> &Uuml;berpr&uuml;fe die Werte von key1.</b><br><br><hr><center><a href=""
     onclick="history.go(-1); return false;"> &lt;&lt; zur&uuml;ck </a>&nbsp;</center><hr>';
  $Translation['foreach key2 without values'] = '<b>FEHLER:  Kann kein Dokument erstellen!<br> &Uuml;berpr&uuml;fe die Werte von key2.</b><br><br><hr><center><a href=""
     onclick="history.go(-1); return false;"> &lt;&lt; zur&uuml;ck </a>&nbsp;</center><hr>';
  $Translation['saved files warning']='Die Dateien (z.B.  <i>%s</i>) werden auf dem Server gespeichert<br> im Dokumenten-Verzeichnis: <b>%s</b><br><br><hr><center><a
     href="" onclick="history.go(-1); return false;"> &lt;&lt; zur&uuml;ck </a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a 
     href="./reports/" > zum Standard Dokumenten-Verzeichnis &gt;&gt;</a></center><hr>';
  $Translation['key definition error']="<BR>FEHLER im Schl&uuml;ssel key (%s = '%s') und Wert !<BR>\n";
  $Translation['click to go']='Hier geht es zum Dokument  &gt;&gt;';
 // ------------ arrays and functions
 //TODO:  set the local timezone (see http://php.net/manual/en/timezones.php)
 function set_local(){
        date_default_timezone_set ('Europe/Berlin');
   }
  // to handle some special chars on XML
   function filter($value){  	 				  
			if ( !((strpos($value,'&amp;') === false)&
			       (strpos($value,'&lt;') === false)&
				     (strpos($value,'&#') === false)) ) return $value;
		  $ret = $value;
			$ret = str_replace("&","&amp;",$ret);
			$ret = str_replace("<","&lt;",$ret);   
 //TODO update this (if required)
 			$ret = str_replace("€","&#8364;",$ret);
			return $ret;  				
		}	  																							

 // ---- date UI
 $month = array('','January','February','Match','April','May','June','July','August','September','October','November','December');
 $year  = array(2010,2011,2012,2013,2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025);
// license LGPL    
?>   
   
