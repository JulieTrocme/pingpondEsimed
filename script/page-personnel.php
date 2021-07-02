<?php
	require 'script/session.php';
	
	require 'script/bdd.php';

	//Clients non validé
	$dataClient = $bdd->query('SELECT * FROM t_ouvrier ou ORDER BY ou_date_inscription');
	$dataClient->execute();
	$clients = $dataClient->fetchAll();
	$dataClient->closeCursor();




	//Liste des rangs
	$dataRangs = $bdd->query('SELECT * FROM t_role WHERE ro_id != 4 ORDER BY ro_id');
	$rangs = $dataRangs->fetchAll();
	$dataRangs->closeCursor();


	//ajout personnel
	if(!empty($_POST) && isset($_POST['add'])) {


            $req = $bdd->prepare("SELECT ou_id FROM t_ouvrier WHERE ou_login = ?");
            $req->execute([$_POST['user_login']]);
            $user = $req->fetch();
            $req->closeCursor();



            if($user) {
                $_SESSION['flash']['danger'] = 'Erreur : Ce login est déjà utilisée';
                $_POST['user_login'] = "";
                header('Location: page-personnel.php');
                exit();
            }


			//Verif mot de passe
			if(empty($_POST['user_password']) || $_POST['user_password'] != $_POST['user_password_confirm']){
				$_SESSION['flash']['danger'] = "Erreur : Les mots de passe ne correspondent pas";
				header('Location: page-personnel.php');
				exit();	
			}

			//Si il n'y à pas d'erreur
			if(empty($_SESSION['flash']['danger'])) {

				$password = password_hash($_POST['user_password'], PASSWORD_BCRYPT);
				$nom = strtoupper($_POST['user_nom']);
                $prenom = ucfirst($_POST['user_prenom']);
                $login = ucfirst($_POST['user_login']);

				$req = $bdd->prepare("INSERT INTO `t_ouvrier`(`ou_nom`, `ou_prenom`, `ou_login`, `ou_mdp`, `ou_date_inscription`) VALUES (?,?,?,?,NOW())");
                $req->execute([$nom,$prenom,$login,$password]);
				$req->closeCursor();

				$lastId = $bdd->lastInsertId();

				foreach ($_POST['role'] as $role){
                    $req = $bdd->prepare("INSERT INTO `r_role_ouvrier`(`ro_id`, `ou_id`) VALUES (?,?)");
                    $req->execute([$role,$lastId]);
                    $req->closeCursor();
                }

                $_SESSION['flash']['success'] = 'Utilisateur ajouté avec succés';
                header('Location: page-personnel.php');
                exit();

			}


    }

