<?php
require 'script/session.php';

require 'script/bdd.php';


require 'script/session.php';

require 'script/bdd.php';


if (isset($_GET['id'])) {

    $id = $_GET['id'];


    //Clients
    $dataClients = $bdd->prepare('SELECT * FROM t_client ');
    $dataClients->execute([]);
    $clients = $dataClients->fetchAll();
    $dataClients->closeCursor();

    //Commande
    $dataCommande = $bdd->prepare('SELECT * FROM t_commande WHERE co_id = ?');
    $dataCommande->execute([$id]);
    $commande = $dataCommande->fetch();
    $dataCommande->closeCursor();


    //Lignes commande
    $dataLigneCommandes = $bdd->prepare('SELECT * FROM `t_ligne_commande` JOIN t_piece ON pi_id = lc_id_art WHERE `lc_id_commande` = ? ');
    $dataLigneCommandes->execute([$id]);
    $lignecommande = $dataLigneCommandes->fetchAll();
    $dataLigneCommandes->closeCursor();


    //Commande
    $dataLigneDevis = $bdd->prepare('SELECT * FROM `t_devis` JOIN t_ligne_devis ON de_id = ld_id_devis JOIN t_piece ON pi_id = ld_id_art WHERE `de_id_client` = ? AND `de_date_delais` >= NOW() AND ld_statut != 1');
    $dataLigneDevis->execute([$commande['co_id_client']]);
    $ligneDevis = $dataLigneDevis->fetchAll();
    $nbLigneDevis = $dataLigneDevis->RowCount();
    $dataLigneDevis->closeCursor();


    //UPDATE commande
    if(!empty($_POST) && isset($_POST['edit_commande'])) {

        $client = $_POST['client'];

        $dataUpdateCommande = $bdd->prepare('UPDATE `t_commande` SET `co_id_client`= ? WHERE `co_id` = ?');
        $dataUpdateCommande->execute([$client,$id]);
        $dataUpdateCommande->closeCursor();


        //On cherche les lignes de commande
        $dataLigneCommande = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id_commande = ?');
        $dataLigneCommande->execute([$id]);
        $lignecommandeDeletes = $dataLigneCommande->fetchAll();
        $dataLigneCommande->closeCursor();

        foreach ($lignecommandeDeletes as $lignecdeDel){
            //On cherche la ligne du devis
            $dataLigneDevis = $bdd->prepare('SELECT * FROM t_devis JOIN t_ligne_devis ON de_id = ld_id_devis WHERE ld_id_art = ? AND de_id_client = ? AND de_date_delais >= NOW()');
            $dataLigneDevis->execute([$lignecdeDel['lc_id_art'],$commande['co_id_client']]);
            $ligneDevis = $dataLigneDevis->fetch();
            $dataLigneDevis->closeCursor();

            //On update la ligne de devis pour qu'elle soit de nouveau visible
            $dataUpdateLigneCommande = $bdd->prepare("UPDATE `t_ligne_devis` SET `ld_statut`= ? WHERE `ld_id` = ?");
            $dataUpdateLigneCommande->execute([0,$ligneDevis['ld_id']]);
            $dataUpdateLigneCommande->closeCursor();
        }


        $dataDelLigneCde = $bdd->prepare('DELETE FROM `t_ligne_commande` WHERE `lc_id_commande` = ?');
        $dataDelLigneCde->execute([$id]);
        $dataDelLigneCde->closeCursor();

        $_SESSION['flash']['success'] = 'Information de la commande client modifié avec succès.';
        header('Location: page-commande-client-edit.php?id='.$id);
        exit();
    }


    //DELETE PIECE
    if(!empty($_POST) && isset($_POST['delete_piece'])) {
        $idLigne = $_POST['pu_id'];


        //On cherche la ligne de commande
        $dataLigneCommande = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id = ?');
        $dataLigneCommande->execute([$idLigne]);
        $lignecommandeDelete = $dataLigneCommande->fetch();
        $dataLigneCommande->closeCursor();

        //On cherche la ligne du devis
        $dataLigneDevis = $bdd->prepare('SELECT * FROM t_devis JOIN t_ligne_devis ON de_id = ld_id_devis WHERE ld_id_art = ? AND de_id_client = ? AND de_date_delais >= NOW()');
        $dataLigneDevis->execute([$lignecommandeDelete['lc_id_art'],$commande['co_id_client']]);
        $ligneDevis = $dataLigneDevis->fetch();
        $dataLigneDevis->closeCursor();

        //On update la ligne de devis pour qu'elle soit de nouveau visible
        $dataUpdateLigneCommande = $bdd->prepare("UPDATE `t_ligne_devis` SET `ld_statut`= ? WHERE `ld_id` = ?");
        $dataUpdateLigneCommande->execute([0,$ligneDevis['ld_id']]);
        $dataUpdateLigneCommande->closeCursor();


        //On delete la ligne de commande
        $dataDltUniteProd = $bdd->prepare("DELETE FROM t_ligne_commande WHERE lc_id = ?");
        $dataDltUniteProd->execute([$idLigne]);
        $dataDltUniteProd->closeCursor();

        //Lignes de commande
        $dataNewLigneCommande = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id_commande = ?');
        $dataNewLigneCommande->execute([$id]);
        $newLigneCommande = $dataNewLigneCommande->fetchAll();
        $dataNewLigneCommande->closeCursor();

        $newMtn = 0;
        foreach ($newLigneCommande as $lc){
            $newMtn += ($lc['lc_qte']*$lc['lc_mtn']);
        }

        //On modifie le montant de la commande
        $dataUpdateDevisMtn = $bdd->prepare("UPDATE `t_commande` SET `co_mtn`= ? WHERE `co_id` = ?");
        $dataUpdateDevisMtn->execute([$newMtn,$id]);
        $dataUpdateDevisMtn->closeCursor();

        $_SESSION['flash']['success'] = 'Piece supprimé avec succès.';
        header('Location: page-commande-client-edit.php?id='.$id);
        exit();

    }

    //Add PIECE devis
    if(!empty($_POST) && isset($_POST['add_ligne_commande'])) {


        foreach ($_POST['ligneDevis'] as $ligneDevi){

            //On cherche le detail de la ligne du devis
            $dataLigneDevisSelect = $bdd->prepare('SELECT * FROM t_ligne_devis WHERE ld_id = ?');
            $dataLigneDevisSelect->execute([$ligneDevi]);
            $ligneDevisSelect = $dataLigneDevisSelect->fetch();
            $dataLigneDevisSelect->closeCursor();

            //ON regarde si la ligne existe déjà dans les lignes de la commande
            $dataLigneDevisExiste = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id_commande = ? AND lc_id_art = ?');
            $dataLigneDevisExiste->execute([$id,$ligneDevisSelect['ld_id_art']]);
            $existe = $dataLigneDevisExiste->fetch();
            $nbExiste = $dataLigneDevisExiste->RowCount();
            $dataLigneDevisExiste->closeCursor();

            if ($nbExiste > 0){

                $newQte = $existe['lc_qte'] + 1;

                //On l'augmente
                $dataUpdatePieceUtil = $bdd->prepare("UPDATE `t_ligne_commande` SET `lc_qte`= ? WHERE `lc_id` = ?");
                $dataUpdatePieceUtil->execute([$newQte,$existe['lc_id']]);
                $dataUpdatePieceUtil->closeCursor();

            }else {

                $newQte = 1;
                //INSERT PIECE DANS DEVIS
                $dataInsDevis = $bdd->prepare("INSERT INTO `t_ligne_commande`(`lc_id_commande`, `lc_id_art`, `lc_qte`, `lc_mtn`) VALUES (?,?,?,?)");
                $dataInsDevis->execute([$id,$ligneDevisSelect['ld_id_art'],$ligneDevisSelect['ld_qte'],$ligneDevisSelect['ld_mtn']]);
                $dataInsDevis->closeCursor();
            }

            //On update la ligne de devis pour que ne soit plus visible
            $dataUpdateLigneDevis = $bdd->prepare("UPDATE `t_ligne_devis` SET `ld_statut`= ? WHERE `ld_id` = ?");
            $dataUpdateLigneDevis->execute([1,$ligneDevisSelect['ld_id']]);
            $dataUpdateLigneDevis->closeCursor();
        }


        //Ligne Devis
        $dataNewLigneCommande = $bdd->prepare('SELECT * FROM t_ligne_commande WHERE lc_id_commande = ?');
        $dataNewLigneCommande->execute([$id]);
        $newLigneCommande = $dataNewLigneCommande->fetchAll();
        $dataNewLigneCommande->closeCursor();

        $newMtn = 0;
        foreach ($newLigneCommande as $lc){
            $newMtn += ($lc['lc_qte']*$lc['lc_mtn']);
        }

        //On modifie le montant du devis
        $dataUpdateDevisMtn = $bdd->prepare("UPDATE `t_commande` SET `co_mtn`= ? WHERE `co_id` = ?");
        $dataUpdateDevisMtn->execute([$newMtn,$id]);
        $dataUpdateDevisMtn->closeCursor();

        $_SESSION['flash']['success'] = 'Ligne de devis ajouté dans la commande avec succès.';
        header('Location: page-commande-client-edit.php?id='.$id);
        exit();



    }



    //VALIDE commande
    if(!empty($_POST) && isset($_POST['valide_commande'])) {


        $dataUpdateCommande = $bdd->prepare('UPDATE `t_commande` SET `co_statut`= ? WHERE `co_id` = ?');
        $dataUpdateCommande->execute([1,$id]);
        $dataUpdateCommande->closeCursor();

        $_SESSION['flash']['success'] = 'Commande validé avec succès.';
        header('Location: page-commande.php');
        exit();
    }




}
