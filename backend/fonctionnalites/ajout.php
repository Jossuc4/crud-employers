<?php

    function genererID(){

        $fichier=__DIR__."/index.txt";

        $lastID=file_get_contents($fichier);
        $index=intval($lastID);
        $index=$index+1;

        $fileHandle = fopen($fichier, 'w');
        $newContent = strval($index);
        fwrite($fileHandle, $newContent);
        fclose($fileHandle);
        
        return "EM".strval(intval($index/100)).strval(intval($index/10)).$index%10;
    } 

    if(!empty($_POST['nom']) && !empty($_POST['nbrJour']) && !empty($_POST['taux'])){
        $nom=$_POST['nom'];
        $nbrJour=$_POST['nbrJour'];
        $taux=$_POST['taux'];

        $requete=$connexion->prepare("INSERT INTO employer VALUES(?,?,?,?)");
        $resultat=$requete->execute([genererID($connexion),$nom,$nbrJour,$taux]);

        if($resultat>0){
            require 'listage.php';
        }
    }

    