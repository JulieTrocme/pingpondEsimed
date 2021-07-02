<?php

  try {
    //$bdd = new PDO('mysql:host=localhost;dbname=bgturbo;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $bdd = new PDO('mysql:host=mysql-jtrocme.alwaysdata.net;dbname=jtrocme_admin;charset=utf8', 'jtrocme', 'esimedpingpong2021', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
  }