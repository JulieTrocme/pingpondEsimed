<?php
	require 'script/session.php';

	if(isset($_GET['id'])) {
		
		require 'script/bdd.php';

		$us_id = $_GET['id'];

		//INFO DU CLIENT
		$data = $bdd->prepare('SELECT * FROM t_ouvrier ou LEFT JOIN r_role_ouvrier ror ON ror.ou_id=ou.ou_id LEFT JOIN t_role ro ON ror.ro_id = ro.ro_id  WHERE ou.ou_id = ?');
		$data->execute([$us_id]);
		$user = $data->fetch();
		$data->closeCursor();


		//Liste des Roles
		$dataRoles = $bdd->query('SELECT * FROM t_role WHERE ro_id != 4 ORDER BY ro_id');
        $dataRoles->execute();
		$roles = $dataRoles->fetchAll();
		$dataRoles->closeCursor();

        //Liste des Roles UTILISES
        $dataRolesUtilises = $bdd->prepare('SELECT * FROM t_role ro  JOIN r_role_ouvrier ror ON ror.ro_id = ro.ro_id WHERE ror.ou_id = ?');
        $dataRolesUtilises->execute([$us_id]);
        $roleUtilises = $dataRolesUtilises->fetchAll();
        $dataRolesUtilises->closeCursor();

        //Liste des qualifications
        $dataQualifs = $bdd->query('SELECT * FROM t_poste_travail ORDER BY pt_id');
        $dataQualifs->execute();
        $qualifs = $dataQualifs->fetchAll();
        $dataQualifs->closeCursor();

        //Liste des qualifications de l'utilisateur
        $dataQualifsUsers = $bdd->prepare('SELECT * FROM r_qualification JOIN t_ouvrier ON qu_id_ouvrier = ou_id JOIN t_poste_travail ON qu_id_poste_travail = pt_id WHERE ou_id = ?');
        $dataQualifsUsers->execute([$us_id]);
        $qualifUsers = $dataQualifsUsers->fetchAll();
        $dataQualifsUsers->closeCursor();




		//BLOCK USER
		if(!empty($_POST) && isset($_POST['user_disabled'])) {
			if($us_id) {

                $reqUser = $bdd->prepare("DELETE FROM `r_role_ouvrier` WHERE `ou_id` = ?");
                $reqUser->execute([$us_id]);
                $reqUser->closeCursor();

				$reqUser = $bdd->prepare("INSERT INTO `r_role_ouvrier`(`ro_id`, `ou_id`) VALUES (?,?)");
				$reqUser->execute([4,$us_id]);
				$reqUser->closeCursor();

				$_SESSION['flash']['success'] = "L'utilisateur est bloqué. Il ne pourra plus se connecter";

				header('Location:  page-personnel-edit.php?id='.$us_id);
				exit();
			}
		}

		//ENABLE USER
		if(!empty($_POST) && isset($_POST['user_enabled'])) {
			if($us_id) {				
				$newRang = $_POST['user_rang_enabled'];

                $reqUser = $bdd->prepare("DELETE FROM `r_role_ouvrier` WHERE `ou_id` = ?");
                $reqUser->execute([$us_id]);
                $reqUser->closeCursor();

                foreach ($_POST['role'] as $role){
                    $reqUser = $bdd->prepare("INSERT INTO `r_role_ouvrier`(`ro_id`, `ou_id`) VALUES (?,?)");
                    $reqUser->execute([$role,$us_id]);
                    $reqUser->closeCursor();
                }


                $_SESSION['flash']['success'] = "L'utilisateur est débloqué. Il pourra maintenant se connecter";

				header('Location: page-personnel-edit.php?id='.$us_id);
				exit();
			}
		}

		//UPDATE DU CLIENT
		if(!empty($_POST) && isset($_POST['user_valid'])) {
			if($us_id) {

				$nom = strtoupper($_POST['user_nom']);
				$prenom = ucfirst($_POST['user_prenom']);
                $login = $_POST['user_login'];



				$req = $bdd->prepare("UPDATE `t_ouvrier` SET `ou_nom`= ?,`ou_prenom`= ?,`ou_login`= ? WHERE `ou_id` = ?");
				$req->execute([$nom,$prenom,$login,$us_id]);
				$req->closeCursor();

                $reqUser = $bdd->prepare("DELETE FROM `r_role_ouvrier` WHERE `ou_id` = ?");
                $reqUser->execute([$us_id]);
                $reqUser->closeCursor();

                foreach ($_POST['role'] as $role){
                    $reqUser = $bdd->prepare("INSERT INTO `r_role_ouvrier`(`ro_id`, `ou_id`) VALUES (?,?)");
                    $reqUser->execute([$role,$us_id]);
                    $reqUser->closeCursor();
                }

				$_SESSION['flash']['success'] = "Utilisateur mis à jour avec succès";

				header('Location: page-personnel-edit.php?id='.$us_id);
				exit();
			}
		}

		//UPDATE MDP
		if (!empty($_POST)&&isset($_POST['user_valid_mdp'])) {

			if(empty($_POST['user_password']) || $_POST['user_password'] != $_POST['user_password_confirm']){

				$_SESSION['flash']['danger'] = "Erreur : Les mots de passe ne correspondent pas";
				header('Location: page-personnel-edit.php?id='.$us_id);
				exit();

			}else{

				$password = password_hash($_POST['user_password'], PASSWORD_BCRYPT);

				$reqMdp = $bdd->prepare("UPDATE t_ouvrier SET ou_mdp = ? WHERE ou_id = ?");
				$reqMdp->execute([$password,$us_id]);
				$reqMdp->closeCursor();
				$_SESSION['flash']['success'] = "Mot de passe mis à jour avec succès";

				header('Location: page-personnel-edit.php?id='.$us_id);
				exit();

			}
				
		}

        //UPDATE QUALIF
        if (!empty($_POST) && isset($_POST['user_qualif'])) {
                $reqMdp = $bdd->prepare("DELETE FROM `r_qualification` WHERE `qu_id_ouvrier` = ?");
                $reqMdp->execute([$us_id]);
                $reqMdp->closeCursor();

                foreach ($_POST['poste'] as $poste) {

                    $reqMdp = $bdd->prepare("INSERT INTO `r_qualification`(`qu_id_poste_travail`, `qu_id_ouvrier`) VALUES (?,?)");
                    $reqMdp->execute([$poste,$us_id]);
                    $reqMdp->closeCursor();


                }

                $_SESSION['flash']['success'] = "Qualification mis à jour avec succès";

                header('Location: page-personnel-edit.php?id='.$us_id);
                exit();


        }



	} else {
	   	header('Location: page-client.php');
    	exit();
	}