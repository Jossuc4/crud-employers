<?php
    $requete=$connexion->query("SELECT * FROM employer ORDER BY nom");
    $donnees=$requete->fetchAll(PDO::FETCH_ASSOC);

    echo  json_encode($donnees);