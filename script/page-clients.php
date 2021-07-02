<?php
require 'script/session.php';

require 'script/bdd.php';

//clients
$dataclients = $bdd->query('SELECT * FROM `t_client`');
$dataclients->execute();
$clients = $dataclients->fetchAll();
$dataclients->closeCursor();