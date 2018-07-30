<?php

try {
    $database = new PDO('mysql:host=localhost;dbname=minichat_lundi;charset=utf8', 'root', '');
}
catch(Exception $e) {
    die('Erreur : Connexion échouée ' . $e->getMessage());
}

function query($sql, $parameters = null)
{
    global $database;

    if ($parameters) {
        $preparedQuery = $database->prepare($sql);

        if(!$preparedQuery) {
            $error = $database->errorInfo();
        }
        else {
            $query = $preparedQuery->execute($parameters);

            if(!$query && !isset($error)) {
                $error = $preparedQuery->errorInfo();
            }
        }
    } else {
        $query = $database->query($sql);

        if(!$query) {
            $error = $database->errorInfo();
        }
    }
    if(isset($error)) {
        die("Erreur SQL : ".print_r($error[2], true));
    }


    return $query;
}