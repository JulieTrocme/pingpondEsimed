<?php
require 'script/session.php';

require 'script/bdd.php';

error_reporting(E_ALL);
ini_set('display_errors', 'on');


if(isset($_GET['id'])) {

    $id = $_GET['id'];

    //PIECE
    $dataPiece = $bdd->prepare('SELECT * FROM t_piece WHERE pi_id = ?');
    $dataPiece->execute([$id]);
    $piece = $dataPiece->fetch();
    $dataPiece->closeCursor();

    //TYPES
    $dataTypes = $bdd->query('SELECT * FROM t_piece_type');
    $dataTypes->execute();
    $types = $dataTypes->fetchAll();
    $dataTypes->closeCursor();


    //Gamme et responsable
    $dataGamResp = $bdd->prepare('SELECT * FROM t_gamme JOIN t_ouvrier ON ga_id_responsable = ou_id WHERE ga_id_piece = ?');
    $dataGamResp->execute([$id]);
    $gamResp = $dataGamResp->fetch();
    $dataGamResp->closeCursor();


    //PIECES
    $dataPieces = $bdd->prepare('SELECT * FROM `t_piece` WHERE pi_id != ?');
    $dataPieces->execute([$id]);
    $pieces = $dataPieces->fetchAll();
    $dataPieces->closeCursor();


    //PIECES
    $dataPieceUtilises = $bdd->prepare('SELECT * FROM `t_piece_fabrique` JOIN t_piece ON pi_id = pf_id_piece_utilise WHERE pf_id_piece_fabrique = ?');
    $dataPieceUtilises->execute([$id]);
    $pieceUtilises = $dataPieceUtilises->fetchAll();
    $dataPieceUtilises->closeCursor();


    //Edit PIECE
    if(!empty($_POST) && isset($_POST['edit_piece'])) {

        $libelle = $_POST['pi_libelle'];
        $type = $_POST['pi_id_type'];
        $prix = $_POST['pi_prix'];
        $stock = $_POST['pi_stock'];
        $ref = $_POST['pi_ref'];
        $fournisseur = $_POST['pi_fournisseur'];

        $dataPieces = $bdd->prepare('SELECT * FROM t_piece WHERE pi_ref != ?');
        $dataPieces->execute([$piece['pi_ref']]);
        $piecesRef = $dataPieces->fetchAll();
        $nbPiecesRef = $dataPieces->RowCount();
        $dataPieces->closeCursor();

        $nbPieces = 0;

        if ($nbPiecesRef > 0) {
            foreach ($piecesRef as $value) {
                if ($value['pi_ref'] == $ref) {
                    $nbPieces += 1;
                }
            }
        }

        if ($nbPieces == 0) {

            $dataAddPiece = $bdd->prepare("UPDATE `t_piece` SET`pi_id_type`= ?,`pi_libelle`= ?,`pi_ref`= ?,`pi_prix`= ?,`pi_fournisseur`= ?,`pi_stock`= ? WHERE `pi_id` = ?");
            $dataAddPiece->execute([$type, $libelle, $ref, $prix, $fournisseur, $stock, $id]);
            $dataAddPiece->closeCursor();

            if ($type == 1){

                $dataDelFabrique = $bdd->prepare("DELETE FROM `t_piece_fabrique` WHERE `pf_id_piece_fabrique` = ?");
                $dataDelFabrique->execute([$id]);
                $dataDelFabrique->closeCursor();
            }

            $_SESSION['flash']['success'] = 'Pièce modifié avec succès.';

            header('Location: page-piece-edit.php?id=' . $id);
            exit();
        } else {
            $_SESSION['flash']['danger'] = 'Vous ne pouvez pas utiliser la même référence qu\'une autre pièce';

            header('Location: page-piece-edit.php?id=' . $id);
            exit();
        }

    }

    //Ajout piece utilisé
    if (!empty($_POST) && isset($_POST['add_piece_fabrique'])) {

        $idPiece = $_POST['pi_id_piece'];
        $qte = $_POST['pf_qte'];

        $dataAddPiece = $bdd->prepare("INSERT INTO `t_piece_fabrique`(`pf_id_piece_fabrique`, `pf_id_piece_utilise`, `pf_qte`) VALUES (?,?,?)");
        $dataAddPiece->execute([$id,$idPiece,$qte]);
        $dataAddPiece->closeCursor();

        $_SESSION['flash']['success'] = 'Pièce utilisé ajouté avec succès.';

        header('Location: page-piece-edit.php?id='.$id);
        exit();

    }

    //UPDATE QTE PIECE
    if(!empty($_POST) && isset($_POST['update_qte'])) {

        $idPiece =  $_POST['id_pu'];
        $qte = $_POST['pu_qte'];


        if ($_POST['pu_qte'] != "" && $_POST['id_pu'] != "") {


            $dataUpdatePieceUtil = $bdd->prepare("UPDATE `t_piece_fabrique` SET `pf_qte`= ? WHERE `pf_id` = ?");
            $dataUpdatePieceUtil->execute([$qte,$idPiece]);
            $dataUpdatePieceUtil->closeCursor();


            $_SESSION['flash']['success'] = 'Quantité pour cette pièce modifié avec succès.';
            header('Location: page-piece-edit.php?id='.$id);
            exit();
        }


    }

    //DELETE Prix
    if(!empty($_POST) && isset($_POST['delete_piece_utilise'])) {
        $idPiece = $_POST['pu_id'];

        $dataDltUniteProd = $bdd->prepare("DELETE FROM t_piece_fabrique WHERE pf_id = ?");
        $dataDltUniteProd->execute([$idPiece]);
        $dataDltUniteProd->closeCursor();


        $_SESSION['flash']['success'] = 'Piece utilisé supprimé avec succès.';

        header('Location: page-piece-edit.php?id='.$id);
        exit();

    }
}