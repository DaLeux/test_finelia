<?php

$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host=localhost;dbname=finelia', 'root', '',$pdo_options);
$bdd -> exec("set names utf8");