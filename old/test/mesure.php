<?php
/**
* Calculer le temps d'execution d'un script
*/
require_once('../api/config/bdd.php');

// relever le point de départ
$timestart=microtime(true);

$s = $cnx->query("SELECT * 
FROM utilisateur 
LEFT JOIN profil 
ON utilisateur.id = profil.id_utilisateur;
")->fetchAll();
foreach($s as $r) {

    echo $r['mail'];
}
//Fin du code PHP
$timeend=microtime(true);
$time=$timeend-$timestart;
 
//Afficher le temps d'éxecution
$page_load_time = number_format($time, 3);
echo "Debut du script: ".date("H:i:s", $timestart);
echo "<br>Fin du script: ".date("H:i:s", $timeend);
echo "<br>Script execute en " . $page_load_time . " sec";
?>