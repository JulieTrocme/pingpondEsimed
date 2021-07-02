<?php
	require 'script/session.php';

	if(isset($_GET['id'])) {
		
		require 'script/bdd.php';

		$cde_id = $_GET['id'];

		//GET Commandes
		$dataCde = $bdd->prepare('SELECT * FROM t_commande c LEFT JOIN t_user u ON c.Cde_Cli_ID = u.us_id LEFT JOIN t_company e ON e.com_id = u.us_company_id WHERE Cde_ID = ?');
		$dataCde->execute([$cde_id]);
		$cde = $dataCde->fetch();
		$dataCde->closeCursor();

		//Liste des articles
		$dataArticles = $bdd->prepare('SELECT * FROM t_commande_ligne JOIN t_besoin ON be_id = CL_Art_ID WHERE CL_Cde_ID = ? ORDER BY CL_ID');
		$dataArticles->execute([$cde_id]);
		$articles = $dataArticles->fetchAll();
		$dataArticles->closeCursor();		

		$dataAdresseLivraison = $bdd->prepare('SELECT * FROM t_user_address ad JOIN t_pays p ON ad.ad_id_state = p.id WHERE ad_id = ?');
		$dataAdresseLivraison->execute([$cde['Cde_Liv']]);
		$adresseLivraison = $dataAdresseLivraison->fetch();
		$dataAdresseLivraison->closeCursor();

	} else {
	   	header('Location: page-commande.php');
    	exit();
	}