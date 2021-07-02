<?php require 'script/page-personnel-edit.php'; ?>
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
							<span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="mdi mdi-home"></i></span>PERSONNEL : <?php echo $user['ou_nom'].' '.$user['ou_prenom']; ?>
						</h3>
						<nav aria-label="breadcrumb">
							<ul class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page">Gestion page Client</li>
							</ul>
						</nav>
					</div>

					<div class="card grid-margin">
						<form method="POST" action="#">
							<div class="card-body">
								<h4 class="card-title">Gestion de l'utilisateur</h4><br>

								<div class="row" id="min-slide">
									<div class="form-group col-md-4">
										<label>nom</label>
										<input type="text" name="user_nom" class="form-control" maxlength="200" placeholder="Texte ici" value="<?php echo $user['ou_nom']; ?>">
									</div>
									<div class="form-group col-md-4">
										<label>Prénom</label>
										<input type="text" name="user_prenom" class="form-control" maxlength="200" placeholder="Texte ici" value="<?php echo $user['ou_prenom']; ?>">
									</div>
									<div class="form-group col-md-4">
										<label>Login</label>
										<input type="text" name="user_login" class="form-control" maxlength="200" placeholder="Texte ici" value="<?php echo $user['ou_login']; ?>">
									</div>

									<?php if ($user['ro_id'] != 4) { ?>
										<div class="form-group col-md-4">
											<label>Rang</label><br>
                                            <?php foreach ($roles as $value) {
                                                $check = 0;
                                                foreach ($roleUtilises as $util){
                                                    if ($util['ro_id'] == $value['ro_id']){
                                                        $check = 1;
                                                    }
                                                }
                                                ?>

                                                <input type="checkbox" id="<?php echo 'role'.$value['ro_id'];?>" name="role[]" value="<?php echo $value['ro_id'];?>" <?php if ($check == 1) {echo 'checked';}?>>
                                                <label for="<?php echo 'role'.$value['ro_id'];?>"> <?php echo $value['ro_libelle'];?></label><br>
                                            <?php } ?>
										</div>
									<?php }?>
									
									<div class="form-group col-md-4">
										<label>Mot de passe</label><br>
										<button type="button" class="btn btn-gradient-warning" data-toggle="modal" data-target="#modalMDP"><i class="fa fa-2x fa-pencil-square-o" aria-hidden="true" style="padding-right:10px;"></i> Modifier</button>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<button type="submit" class="btn btn-success pull-right" name="user_valid">Enregistrer</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>

                    <div class="card grid-margin">
                            <div class="card-body">


                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="card-title float-left">Gestion des qualifications de l'utilisateur</h4>
                                        <button type="button" class="btn btn-gradient-warning float-right" style="margin-left:10px;" data-toggle="modal" data-target="#modalQualif"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> Qualification</button>
                                    </div>
                                    <div class="col-md-12 pl-5 pt-4">
                                        <?php foreach ($qualifUsers as $qualif){
                                            echo '<p>'.$qualif['pt_libelle'].'</p><br>';
                                        } ?>

                                    </div>

                                </div>
                            </div>
                    </div>

		            <!-- Gestion de l'utilisateur-->
					<div class="card grid-margin">
						<div class="card-body">
							<h4 class="card-title">Gestion de l'utilisateur</h4><br>
							<form method="POST" action="#">
								<?php if ($user['ro_id'] != 4) {
										echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal"><i class="fa fa-ban" aria-hidden="true" style="padding-right:10px;"></i> Bloquer</button>' ;
									}
									else{
										echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalEnabled"><i class="fa fa-check" aria-hidden="true" style="padding-right:10px;"></i> Débloquer</button>' ;
									}

								?>
							</form>
						</div>
		            </div>

		        </div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
			        <h5 class="modal-title" id="exampleModalLabel">Bloquer ce client</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <form action="#" method="POST">
				      <div class="card-body">
				       		<h6>Bloquer ce client veut dire qu'il ne pourra plus se connecter pour commander, vous pourrez le débloquer à tout moment</h6>
				      </div>
				      <div class="card-footer">
				        <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
				        <button type="submit" name="user_disabled" class="btn btn-success pull-right">Valider</button>
				      </div>
				  </form>
			    </div>
			  </div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="ModalEnabled" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
			        <h5 class="modal-title" id="exampleModalLabel">Débloquer ce client</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <form action="#" method="POST">
				      <div class="card-body">
				       		<div class="form-group col-md-8">
								<label>Quels rang voulez-vous qu'il soit ?</label><br>
                                <?php foreach ($roles as $value) {?>

                                    <input type="checkbox" id="<?php echo 'role'.$value['ro_id'];?>" name="role[]" value="<?php echo $value['ro_id'];?>">
                                    <label for="<?php echo 'role'.$value['ro_id'];?>"> <?php echo $value['ro_libelle'];?></label><br>
                                <?php } ?>
							</div>
				      </div>
				      <div class="card-footer">
				        <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
				        <button type="submit" name="user_enabled" class="btn btn-success pull-right">Valider</button>
				      </div>
				  </form>
			    </div>
			  </div>
			</div>

			<!-- Modal mot de passe -->
			<div class="modal fade" id="modalMDP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
			        <h5 class="modal-title" id="exampleModalLabel">Modifier mot de passe</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <form action="#" method="POST">
				      <div class="card-body">
				       		<div class="form-group col-md-8">
								<label>Mot de passe</label>
								<input type="password" name="user_password" class="form-control" placeholder="Mot de passe">
							</div>
							<div class="form-group col-md-8">
								<label>Confirmation mot de passe</label>
								<input type="password" name="user_password_confirm" class="form-control" placeholder="Confirmation mot de passe">
							</div>
				      </div>
				      <div class="card-footer">
				        <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
				        <button type="submit" name="user_valid_mdp" class="btn btn-success pull-right">Valider</button>
				      </div>
				  </form>
			    </div>
			  </div>
			</div>

            <!-- Modal qualification -->
            <div class="modal fade" id="modalQualif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                            <h5 class="modal-title" id="exampleModalLabel">Modification des qualifications</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="#" method="POST">
                            <div class="card-body">
                                <div class="form-group col-md-12">
                                    <?php foreach ($qualifs as $qualif){
                                        $check = 0;
                                        foreach ($qualifUsers as $util){
                                            if ($util['pt_id'] == $qualif['pt_id']){
                                                $check = 1;
                                            }
                                        }
                                        ?>
                                        <input type="checkbox" id="<?php echo 'poste'.$qualif['pt_id'];?>" name="poste[]" value="<?php echo $qualif['pt_id'];?>" <?php if ($check == 1) {echo 'checked';}?>>
                                        <label for="<?php echo 'poste'.$qualif['pt_id'];?>"> <?php echo $qualif['pt_libelle'];?></label><br>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                                <button type="submit" name="user_qualif" class="btn btn-success pull-right">Valider</button>
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

      	$('td.ad_upd').on('click', function() {
	        var myModal = $('#Modal-adresse-update');
	        // now get the values from the table
	        var id = $(this).closest('tr').find('td.ad_id').html();
	        var surname = $(this).closest('tr').find('td.ad_surname').html();
	        var name = $(this).closest('tr').find('td.ad_name').html();
	        var company = $(this).closest('tr').find('td.ad_company').html();
	        var adresse1 = $(this).closest('tr').find('td.ad_address_1').html();
	        var adresse2 = $(this).closest('tr').find('td.ad_address_2').html();
	        var city = $(this).closest('tr').find('td.ad_city').html();
	        var cp = $(this).closest('tr').find('td.ad_cp').html();
	        var state = $(this).closest('tr').find('td.ad_id_state').html();
	        var tel = $(this).closest('tr').find('td.ad_tel').html();
	        
	        // and set them in the modal:
	        $('.ad_id_upd', myModal).val(id);
	        $('.ad_surname_upd', myModal).val(surname);
	        $('.ad_name_upd', myModal).val(name);
	        $('.ad_company_upd', myModal).val(company);
	        $('.ad_address_1_upd', myModal).val(adresse1);
	        $('.ad_address_2_upd', myModal).val(adresse2);
	        $('.ad_city_upd', myModal).val(city);
	        $('.ad_cp_upd', myModal).val(cp);
	        $('.ad_tel_upd', myModal).val(tel);

	        $(".ad_state_upd option[value='"+state+"']:first").attr("selected","selected");
	        // and finally show the modal
	        myModal.modal({ show: true });
	        return false;
      	});
    
    </script>


</body>
</html>