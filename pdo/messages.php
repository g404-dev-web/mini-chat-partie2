<?php

include('connection.php');

$messagesInitCount = 50;

$queryLimit = 'LIMIT 0, '.$messagesInitCount;

$messagesQuery = query(
    'SELECT m.*, u.color 
    FROM messages m
    LEFT OUTER JOIN users u 
    on m.nickname = u.nickname '.
    ' ORDER BY id DESC '.$queryLimit
);

$messages = array_reverse($messagesQuery->fetchAll());