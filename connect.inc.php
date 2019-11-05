<?php

try{
    $connString = "mysql:host=localhost;dbname=csci409sp19";
    $user = "csci409sp19";
    $pass = "csci409sp19!";
    $pdo = new PDO($connString,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    die( $e->getMessage() );
}

