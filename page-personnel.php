<?php require 'script/page-personnel.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<?php require 'base/head.php'; ?>

<body>
	<div class="container-scroller">

		<?php require 'base/header.php'; ?>

		<div class="container-fluid page-body-wrapper">

			<?php require 'base/header-left.php'; ?>

			<div class="main-panel">
				<div class="content-wrapper">

					<div class="page-header">
						<h3 class="page-title">
							<span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="mdi mdi-account"></i></span>CLIENTS 
						</h3>
						<nav aria-label="breadcrumb">
							<ul class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page">Gestion des Clients</li>
							</ul>
						</nav>
					</div>

					<!-- tableau client -->
					<div class="card grid-margin">
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<h4 class="card-title float-left">Gestion du personnel</h4>
									<button type="button" class="btn btn-gradient-warning float-right" style="margin-left:10px;" data-toggle="modal" data-target="#modalClient"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> Personnel</button>
								</div>
								<div class="col-12 mt-5 table-responsive">
				                    <table id="data_acti" class="table table-bordered table-hover">
				                        <thead>
				                            <tr>
				                                <th class="no-wrap">#</th>
				                                <th class="no-wrap">Nom/Prénom</th>
				                                <th class="no-wrap">login</th>
				                                <th class="no-wrap">Date ajout</th>
				                                <th class="no-wrap">Rang</th>
                                                <th class="no-wrap">Dernière connexion</th>
                                                <th class="no-wrap text-right"></th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <?php foreach ($clients as $user) { ?> 
				                            <tr>
				                            	<td></td>
				                            	<td><?php echo $user['ou_nom'].' '.$user['ou_prenom']; ?></td>
				                            	<td><?php echo $user['ou_login']; ?></td>
                                                <td><?php echo date('d/m/Y H:i:s', strtotime(str_replace('-','/', $user['ou_date_inscription']))); ?></td>

				                            	<td>

                                                    <?php

                                                    $dataRoleClient = $bdd->prepare('SELECT * FROM t_role ro JOIN r_role_ouvrier ror ON ror.ro_id = ro.ro_id WHERE ror.ou_id = ?');
                                                    $dataRoleClient->execute([$user['ou_id']]);
                                                    $roles = $dataRoleClient->fetchAll();
                                                    $dataRoleClient->closeCursor();

                                                   foreach ($roles as $role){
                                                       if ($role['ro_id'] == 1) {
                                                           echo '<p class="userNormal mb-1 mt-1 text-center">'.$role['ro_libelle'] .'</p>';
                                                       } if ($role['ro_id'] == 2) {
                                                           echo '<p class="userSup mb-1 mt-1 text-center">'.$role['ro_libelle'] .'</p>';
                                                       } if ($role['ro_id'] == 3) {
                                                           echo '<p class="userSup2 mb-1 mt-1 text-center">'.$role['ro_libelle'] .'</p>';
                                                       } if ($role['ro_id'] == 4) {
                                                           echo '<p class="userBloquer mb-1 mt-1 text-center ">'.$role['ro_libelle'] .'</p>';
                                                       }
                                                   }
                                                    ?>
				                            		

				                            	</td>
                                                <td><?php echo date('d/m/Y H:i:s', strtotime(str_replace('-','/', $user['ou_derniere_connexion']))); ?></td>
				                            	<td class="text-center"><a href="page-personnel-edit.php?id=<?php echo $user['ou_id'];?>"><i class="fa fa-2x fa-pencil-square-o" aria-hidden="true" style="color:green;"></i></a></td>
				                            </tr>
				                            <?php } ?>
				                        </tbody>
				                    </table>    
								</div>
							</div>			
						</div>
		            </div>
				</div>
			</div>

			<!-- Modal ajout ouvrier -->
			<div class="modal fade" id="modalClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
			        <h5 class="modal-title" id="exampleModalLabel">Ajouter utilisateur</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      	<form action="#" method="POST">
				      	<div class="card-body">
				      		<div class="row">
			       				<div class="form-group col-md-4">
									<label>nom</label>
									<input type="text" name="user_nom" class="form-control" maxlength="200" placeholder="Nom" required>
								</div>
								<div class="form-group col-md-4">
									<label>Prénom</label>
									<input type="text" name="user_prenom" class="form-control" maxlength="200" placeholder="Prénom" required>
								</div>
								<div class="form-group col-md-4">
									<label>Login</label>
									<input type="text" name="user_login" class="form-control" maxlength="200" placeholder="Login" required>
								</div>

								<div class="form-group col-md-4">
									<label>Role</label><br>
                                    <?php foreach ($rangs as $value) {?>

                                    <input type="checkbox" id="<?php echo 'role'.$value['ro_id'];?>" name="role[]" value="<?php echo $value['ro_id'];?>">
                                    <label for="<?php echo 'role'.$value['ro_id'];?>"> <?php echo $value['ro_libelle'];?></label><br>
                                    <?php } ?>
								</div>
								<div class="form-group col-md-4">
									<label>Mot de passe</label><br>
									<input type="password" name="user_password" class="form-control" maxlength="200" placeholder="Mot de passe" required>
								</div>
								<div class="form-group col-md-4">
									<label>Corfimation mot de passe</label><br>
									<input type="password" name="user_password_confirm" class="form-control" maxlength="200" placeholder="Confirmation mot de passe" required>
								</div>
							</div>
				      </div>
				      <div class="card-footer">
				        <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
				        <button type="submit" name="add" class="btn btn-success pull-right">Ajouter</button>
				      </div>
				  </form>
			    </div>
			  </div>
			</div>

		</div>
		<!-- page-body-wrapper ends -->
	</div>

	<?php require 'base/script.php'; ?>
	<script src="assets/vendors/tinymce/tinymce.min.js"></script>
	<script src="assets/vendors/tinymce/themes/modern/theme.js"></script>

	<!-- jqueryUI.js -->
	<script src="assets/vendors/js/jqueryUI.js"></script>


	<script type="text/javascript">			

	document.getElementById("useH").className += " active";


	$('#data_acti').DataTable({
	      "order": [[ 4, "desc" ]],
	      "aLengthMenu": [
	        [10, 20, 50, 100, 250],
	        [10, 20, 50, 100, 250]
	      ],
	      "columnDefs": [
	              {
	                  "targets": [ 0 ],
	                  "visible": false,
	                  "searchable": false,
	              },
	              {
	              	  "targets": [ 4 ],
	              	  "type": "date-euro"
	              }
	      ],
	      "iDisplayLength": 10,
	      "language": {
	        "sProcessing":     "Traitement en cours...",
	        "sSearch":         "Recherche",
	        "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
	        "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
	        "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
	        "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
	        "sInfoPostFix":    "",
	        "sLoadingRecords": "Chargement en cours...",
	        "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
	        "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
	        "oPaginate": {
	          "sFirst":      "Premier",
	          "sPrevious":   "Pr&eacute;c&eacute;dent",
	          "sNext":       "Suivant",
	          "sLast":       "Dernier"
	        },
	        "oAria": {
	          "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
	          "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
	        },
	        "select": {
	          "rows": {
	            _: "%d lignes séléctionnées",
	            0: "Aucune ligne séléctionnée",
	            1: "1 ligne séléctionnée"
	          }
	        }
	      }
	    });

		jQuery.extend( jQuery.fn.dataTableExt.oSort, {
			    "date-euro-pre": function ( a ) {
			        var x;
			 
			        if ( $.trim(a) !== '' ) {
			            var frDatea = $.trim(a).split(' ');
			            var frTimea = (undefined != frDatea[1]) ? frDatea[1].split(':') : [00,00,00];
			            var frDatea2 = frDatea[0].split('/');
			            x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + ((undefined != frTimea[2]) ? frTimea[2] : 0)) * 1;
			        }
			        else {
			            x = Infinity;
			        }
			 
			        return x;
			    },
			 
			    "date-euro-asc": function ( a, b ) {
			        return a - b;
			    },
			 
			    "date-euro-desc": function ( a, b ) {
			        return b - a;
			    }
			} );



</script>

</body>
</html>