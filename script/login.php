<?php 

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

error_reporting(E_ALL);
ini_set('display_errors', 'on');

	if(!empty($_POST) && isset($_POST['login'])) {

		if(!isset($_POST['username']) || $_POST['username'] == '' || !isset($_POST['password']) || $_POST['password'] == '') {
			$_SESSION['flash']['warning'] = "Merci de remplir le formulaire";
			header ("location: login.php");
			exit;
		}

		require 'bdd.php';

	    //get the username and password
        $username = $_POST['username'];



	 	//get Admin user by login name
		$data = $bdd->prepare("SELECT * FROM t_ouvrier WHERE ou_login = ?");
		$data->execute([$username]);

		if($data->rowCount() > 0) {

			$admin = $data->fetch();

            if($admin['ou_id_role'] == 4) {
                $_SESSION['flash']['danger'] = 'Erreur : Votre compte est bloqué. Merci de nous contacter';
            } elseif(password_verify($_POST['password'], $admin['ou_mdp'])) {
                $_SESSION['admin_login'] = $admin;

                //UPDATE date de connexion de l'utilisateur
                $req = $bdd->prepare("UPDATE `t_ouvrier` SET ou_derniere_connexion = NOW() WHERE `ou_id` = ?");
                $req->execute([$admin['ou_id']]);
                $req->closeCursor();

                $_SESSION['flash']['success'] = "Bonjour " . ucfirst($admin['ou_login']) . ", bienvenue dans l'espace d'administration.";


            }
            header("location: index.php");
            exit;

		} else {
			$_SESSION['flash']['warning'] = "Identifiant incorrect";
			header ("location: login.php");
			exit;
		}
	}
