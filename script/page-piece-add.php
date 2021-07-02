<?php
	require 'script/session.php';

	require 'script/bdd.php';


    //TYPES
    $dataTypes = $bdd->query('SELECT * FROM t_piece_type');
    $dataTypes->execute();
    $types = $dataTypes->fetchAll();
    $dataTypes->closeCursor();

    //Responsables
    $dataResponsables = $bdd->query('SELECT * FROM t_ouvrier');
    $dataResponsables->execute();
    $responsables = $dataResponsables->fetchAll();
    $dataResponsables->closeCursor();

	//ADD PIECE
	if(!empty($_POST) && isset($_POST['add_piece'])) {

        $libelle = $_POST['pi_libelle'];
        $type = $_POST['pi_id_type'];
        $prix = $_POST['pi_prix'];
        $stock = $_POST['pi_stock'];
        $ref = $_POST['pi_ref'];
        $fournisseur = $_POST['pi_fournisseur'];

        $image = '/assets/images/pieces/'.$_POST['ac_image'];

        $dataPieces = $bdd->prepare('SELECT * FROM t_piece WHERE pi_ref = ?');
        $dataPieces->execute([$ref]);
        $nbPieces = $dataPieces->RowCount();
        $dataPieces->closeCursor();

        if ($nbPieces == 0){

            $dataAddPiece = $bdd->prepare("INSERT INTO `t_piece`(`pi_image`, `pi_id_type`, `pi_libelle`, `pi_ref`, `pi_prix`, `pi_fournisseur`, `pi_stock`) VALUES (?,?,?,?,?,?,?)");
            $dataAddPiece->execute([$image,$type,$libelle,$ref,$prix,$fournisseur,$stock]);
            $dataAddPiece->closeCursor();


            $_SESSION['flash']['success'] = 'Pièce ajouté avec succès.';

            header('Location: page-pieces');
            exit();
        } else {

            $_SESSION['flash']['danger'] = 'La référence que vous avez rentré est déjà utilisé';

            header('Location: page-piece-add');
            exit();
        }



	}