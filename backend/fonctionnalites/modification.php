<?php

    if(!empty($_POST['numEmp']) && !empty($_POST['nom']) && !empty($_POST['nbrJour']) && !empty($_POST['taux'])){
        $nom=$_POST['nom'];
        $nbrJour=$_POST['nbrJour'];
        $taux=$_POST['taux'];

        $requete=$connexion->prepare("UPDATE employer SET nom=?,nbrJour=?,taux=? WHERE numEmp=?");
        $resultat=$requete->execute([$nom,$nbrJour,$taux,$_POST['numEmp']]);
        if($resultat>0){
            require 'listage.php';
        }
    }