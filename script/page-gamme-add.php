<?php
require 'script/session.php';

require 'script/bdd.php';

//Responsables
$dataResponsables = $bdd->query('SELECT * FROM t_ouvrier');
$dataResponsables->execute();
$responsables = $dataResponsables->fetchAll();
$dataResponsables->closeCursor();


//PIECES
$dataPieces = $bdd->prepare('SELECT * FROM `t_piece` WHERE pi_id_type != 1');
$dataPieces->execute();
$pieces = $dataPieces->fetchAll();
$dataPieces->closeCursor();

//GAMMES
$dataGammes = $bdd->prepare('SELECT * FROM `t_gamme`');
$dataGammes->execute();
$gammes = $dataGammes->fetchAll();
$dataGammes->closeCursor();

//ADD GAMME
if(!empty($_POST) && isset($_POST['add_piece'])) {

    $libelle = $_POST['pi_libelle'];
    $responsable = $_POST['pi_id_responsable'];
    $piece = $_POST['pi_id_piece'];



    $dataAddPiece = $bdd->prepare("INSERT INTO `t_gamme`(`ga_id_responsable`, `ga_id_piece`, `ga_libelle`) VALUES (?,?,?)");
    $dataAddPiece->execute([$responsable,$piece,$libelle]);
    $dataAddPiece->closeCursor();


    $lastId = $bdd->lastInsertId();

    $_SESSION['flash']['success'] = 'Gamme ajouté avec succès.';

    header('Location: page-gamme-edit.php?id='.$lastId);
    exit();

}