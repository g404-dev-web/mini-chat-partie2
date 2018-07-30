<?php

use Colors\RandomColor;

include('../vendor/autoload.php');
include('connection.php');

function get_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

// Insertion du message à l'aide d'une requête préparée
query(
    'INSERT INTO messages (nickname, message, ip, user_agent) VALUES (?, ?, ?, ?)',
    [$_POST["nickname"], $_POST["message"], get_ip(), $_SERVER['HTTP_USER_AGENT']]
);


// Ce nickname a-t-il déjà une couleur unique ?
$nicknameQuery = query('SELECT count(*) FROM users WHERE nickname=' . $database->quote($_POST['nickname']));

// Insertion de la couleur unique du nickname
if ($nicknameQuery->fetchColumn() === "0") {
    $color = RandomColor::one();

    query(
        'INSERT INTO users (nickname, color) VALUES(?, ?)',
        array($_POST['nickname'], $color)
    );
}

setcookie(
    'nickname',
    $_POST["nickname"],
    time() + 365 * 24 * 3600,
    '/',
    null,
    false,
    true
);