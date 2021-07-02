<?php
	require 'script/session.php';

	require 'script/bdd.php';

//PIECES
$dataPieces = $bdd->query('SELECT * FROM `t_piece` LEFT JOIN t_piece_type ON ty_id = pi_id_type LEFT JOIN t_gamme ON ga_id_piece = pi_id LEFT JOIN t_ouvrier ON ga_id_responsable = ou_id');
$dataPieces->execute();
$pieces = $dataPieces->fetchAll();
$dataPieces->closeCursor();


//GAMMES
$dataGammes = $bdd->query('SELECT * FROM `t_gamme` JOIN t_ouvrier ON ou_id = ga_id_responsable JOIN t_piece ON pi_id = ga_id_piece');
$dataGammes->execute();
$gammes = $dataGammes->fetchAll();
$dataGammes->closeCursor();


//DELETE PIECE
if(!empty($_POST) && isset($_POST['delete_piece'])) {

    $idPiece = $_POST['pi_id'];

    $dataPieceTrouve = $bdd->prepare('SELECT * FROM `t_gamme` WHERE `ga_id_piece` = ?');
    $dataPieceTrouve->execute([$idPiece]);
    $nbPieceUtilise = $dataPieceTrouve->RowCount();
    $dataPieceTrouve->closeCursor();


    if ($nbPieceUtilise == 0) {

        $dataDelMach = $bdd->prepare("DELETE FROM `t_piece` WHERE `pi_id` = ?");
        $dataDelMach->execute([$idPiece]);
        $dataDelMach->closeCursor();

        $_SESSION['flash']['success'] = 'Pièce supprimé avec succès.';

        header('Location: page-pieces');
        exit();

    } else {
        $_SESSION['flash']['danger'] = 'Impossible de supprimer, cette pièce est utilisé';

        header('Location: page-pieces');
        exit();

    }
}

//DELETE GAMME
if(!empty($_POST) && isset($_POST['delete_gamme'])) {

    $idgamme = $_POST['ga_id'];

    $dataDelGammeOp = $bdd->prepare("DELETE FROM `r_gamme_operation` WHERE `ga_id` = ?");
    $dataDelGammeOp->execute([$idgamme]);
    $dataDelGammeOp->closeCursor();

    $dataDelGamme = $bdd->prepare("DELETE FROM `t_gamme` WHERE `ga_id` = ?");
    $dataDelGamme->execute([$idgamme]);
    $dataDelGamme->closeCursor();

    $_SESSION['flash']['success'] = 'Gamme supprimé avec succès.';

    header('Location: page-pieces');
    exit();


}