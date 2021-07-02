<?php
require 'script/session.php';

require 'script/bdd.php';


if(isset($_GET['id'])) {

    $id = $_GET['id'];


    $dataOperation = $bdd->prepare('SELECT * FROM t_operation op JOIN r_gamme_operation gop ON op.op_id = gop.op_id WHERE gop.ga_id = ?');
    $dataOperation->execute([$id]);
    $operations = $dataOperation->fetchAll();
    $dataOperation->closeCursor();

    //gamme
    $dataGamme = $bdd->prepare('SELECT * FROM t_gamme JOIN t_ouvrier ON ga_id_responsable = ou_id JOIN t_piece ON pi_id = ga_id_piece WHERE ga_id = ?');
    $dataGamme->execute([$id]);
    $gamme = $dataGamme->fetch();
    $dataGamme->closeCursor();


    //On récupère les données de la pièce pour cette gamme
    $dataPieces = $bdd->prepare('SELECT * FROM `t_piece` WHERE pi_id = ?');
    $dataPieces->execute([$gamme['ga_id_piece']]);
    $piece = $dataPieces->fetch();
    $dataPieces->closeCursor();

    //On regarde si la fabrication de cette pièce utilise d'autre pièce
    $dataFabrique = $bdd->prepare('SELECT * FROM t_piece_fabrique JOIN t_piece ON pi_id = pf_id_piece_utilise WHERE pf_id_piece_fabrique = ?');
    $dataFabrique->execute([$gamme['ga_id_piece']]);
    $fabriques = $dataFabrique->fetchAll();
    $nbFabrique = $dataFabrique->RowCount();
    $dataFabrique->closeCursor();

    //Si ça utilise d'autre pièce
    if ($nbFabrique > 0){
        $pasStockMessage = '';
        $nbPasStock = 0;
        //on regarde si il y a assez de stock de chaque pièce avant de modifier le stock
        foreach ($fabriques as $fa){
            if ($fa['pi_stock'] == 0 && $fa['pi_stock'] - $fa['pf_qte'] < 0 ) {
                $pasStockMessage .= 'la pièce "'.$fa['pi_libelle'].'" n\'a pas assez de stock, ';
                $nbPasStock += 1;
            }
        }

        if ($nbPasStock == 0){

            //Si il y a le stock on peut modifier le stock de chaque pièce et faire la duplication des opérations
            foreach ($fabriques as $fabrique){

                $newStockPiece = $fabrique['pi_stock'] - $fabrique['pf_qte'];

                $dataUpdStockPiece = $bdd->prepare("UPDATE `t_piece` SET `pi_stock`= ? WHERE `pi_id` = ?");
                $dataUpdStockPiece->execute([$newStockPiece,$fabrique['pi_id']]);
                $dataUpdStockPiece->closeCursor();
            }

            $newStockPieceFabrique = $gamme['pi_stock'] + 1;

            $dataUpdStockPieceFabrique = $bdd->prepare("UPDATE `t_piece` SET `pi_stock`= ? WHERE `pi_id` = ?");
            $dataUpdStockPieceFabrique->execute([$newStockPieceFabrique,$gamme['pi_id']]);
            $dataUpdStockPieceFabrique->closeCursor();

            $now = date("Y-m-d H:i:s");

            foreach ($operations as $value){


                //Duplication des opérations de la gamme dans réalisation
                $dataAddRea = $bdd->prepare("INSERT INTO `t_realisation`(`re_id_machine`, `re_id_poste`, `re_temps_realisation`, `re_libelle`,`re_date_effectue`) VALUES (?,?,?,?,?)");
                $dataAddRea->execute([$value['op_id_machine'],$value['op_id_poste'],$value['op_temps_realisation'],$value['op_libelle'],$now]);
                $dataAddRea->closeCursor();

                $lastId = $bdd->lastInsertId();

                //On associe les réalisations la gamme
                $dataAddRea = $bdd->prepare("INSERT INTO `r_gamme_realisation`(`ga_id`, `re_id`) VALUES (?,?)");
                $dataAddRea->execute([$id,$lastId]);
                $dataAddRea->closeCursor();

            }

            $_SESSION['flash']['success'] = 'Réalisation enregistré';
            header('Location: page-realisation-edit.php?id='.$gamme['ga_id'].'&date='.$now);
            exit();

        } else {
            $_SESSION['flash']['danger'] = 'Attention '.$pasStockMessage.' la pièce "'.$gamme['pi_libelle'].'" ne peut dont pas être fabriqué';
            header('Location: page-pieces');
            exit();
        }
    }

}