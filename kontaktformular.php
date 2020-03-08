<?php

header('Content-type: text/html; charset=utf-8');

// Einstellungen
$betreff = "Anfrage ueber Formular";
$name_absender = 'Formular Webseite Hotel';
$email_absender = 'erich@webeitehotel.ch';
$email_empfaenger = 'user13@apply.ch';

// Daten
$frm_sent = stripslashes(trim($_POST['sent']));
$frm_name = stripslashes(trim($_POST['name']));
$frm_email = stripslashes(trim($_POST['email']));
$frm_nachricht = stripslashes(trim($_POST['nachricht']));



// IP-Adresse ermitteln
function get_userIP() {
  $IPAry =  array('HTTP_CLIENT_IP','HTTP_X_FORWARDED_FOR','REMOTE_ADDR');
  while (list(,$val) = each($IPAry))
  {
    if( getenv($val) && getenv($val)!='unknown' ) return getenv($val);
  }
  return 'unknown';
}

$ip_adresse = get_userIP();

// Datum
$datum = date("d.m.Y - H:i");

// E-Mail Text
$mail = "Anfrage von Kontaktformular
------------------------------------------------------------------

Name: $frm_name

E-Mail: $frm_email

Nachricht: ".str_replace("\r\n", "\n", $frm_nachricht)."

------
".$datum. " Uhr, IP: ".$ip_adresse;

// UTF-8 umwandeln
$mail = utf8_decode($mail);

// Email versenden
mail($email_empfaenger,$betreff,$mail, "From: $name_absender <$email_absender>");

// Danke-Seite festlegen
$relative_url = 'Step12_Danke.html';

// Danke Seite ausgeben
$loc_verzeichnis = dirname($_SERVER['PHP_SELF']);
If(($loc_verzeichnis == '/') OR ($loc_verzeichnis == '\\')){$loc_verzeichnis = '';}
header("Location: http://".$_SERVER['HTTP_HOST'].$loc_verzeichnis."/".$relative_url);

exit();

?>