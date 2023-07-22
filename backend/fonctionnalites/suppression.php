<?php

    if(!empty($_POST['numEmp'])){
        $requete=$connexion->prepare("DELETE FROM employer WHERE numEmp=?");
        $resultat=$requete->execute([$_POST['numEmp']]);
        if($resultat>0){
            require 'listage.php';
        }
    }