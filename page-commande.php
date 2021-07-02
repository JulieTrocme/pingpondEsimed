<?php require 'script/page-commande.php'; ?>
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

					<!-- tableau commande client -->
					<div class="card grid-margin">
						<div class="card-body">
							<div class="row">
								<div class="col-12 mb-5">
									<h4 class="card-title float-left">Gestion des Commandes client</h4>

                                    <button type="button" class="btn btn-gradient-warning float-right" style="margin-left:10px;" data-toggle="modal" data-target="#modalCommande"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> Commande</button>
								</div>
                                <div class="col-7">
                                    <form method="POST" action="listeFactureCSV.php">
                                        <label>Mois</label>
                                        <div class="row">
                                            <div class="col-8">
                                                <select name="mois" class="form-control">
                                                    <option value="">--Choisir le mois --</option>
                                                    <option value="01">Janvier</option>
                                                    <option value="02">Février</option>
                                                    <option value="03">Mars</option>
                                                    <option value="04">Avril</option>
                                                    <option value="05">Mai</option>
                                                    <option value="06">Juin</option>
                                                    <option value="07">Juillet</option>
                                                    <option value="08">Août</option>
                                                    <option value="09">Septembre</option>
                                                    <option value="10">Octobre</option>
                                                    <option value="11">Novembre</option>
                                                    <option value="12">Décembre</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <button type="submit" name="genere_excel_client" class="btn btn-gradient-warning "> Généré Excel</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
								<div class="col-12 mt-5">
				                    <table class="table table-bordered table-hover data-besoin">
				                        <thead>
				                            <tr>
				                                <th class="no-wrap">#</th>
                                                <th class="no-wrap">N° Cde</th>
                                                <th class="no-wrap">Client</th>
				                                <th class="no-wrap">Date commande</th>
				                                <th class="no-wrap">Montant</th>
				                                <th class="no-wrap">Statut</th>
				                                <th class="no-wrap text-right"></th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <?php foreach ($commandeClients as $value) { ?>
				                            <tr>
				                            	<td><?php echo $value['co_id']; ?></td>
				                            	<td><?php echo str_pad($value['co_id'], 6, "0", STR_PAD_LEFT); ?></td>
				                            	<td><?php echo $value['cl_nom']; ?></td>
				                            	<td><?php echo date('d/m/Y H:i:s', strtotime(str_replace('-','/', $value['co_date']))); ?></td>
                                                <td><?php echo $value['co_mtn']; ?></td>
                                                <td><?php
                                                    if ($value['co_statut'] == 1) {
                                                        echo '<p style="background-color: green;" class=" userSup mb-1 mt-1 text-center">Terminé</p>';
                                                    } else {
                                                        echo '<p style="background-color: red;" class=" userSup mb-1 mt-1 text-center">En cours</p>';
                                                    }
                                                    ?></td>
				                            	<td class="text-center">
                                                    <a style="width: 130px;padding: 4px;" href="page-commande-client-edit.php?id=<?php echo $value['co_id'];?>" class="btn btn-gradient-warning mb-2"><?php if ($value['co_statut']){ echo 'Consulter';}else { echo 'Modifier';}?></a><br>
                                                    <?php if ($value['co_statut']){ ?><a style="width: 130px;padding: 4px;" href="page-commande-client-pdf.php?orderID=<?php echo $value['co_id'];?>" class="btn btn-gradient-warning mb-2">Facture</a> <?php }?>
				                            	</td>
				                            </tr>
				                            <?php } ?>
				                        </tbody>
				                    </table>    
								</div>
							</div>			
						</div>
		            </div>


                    <!-- tableau commande d'achat -->
                    <div class="card grid-margin">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-5">
                                    <h4 class="card-title float-left">Gestion des commandes d'achat</h4>
                                    <a  class="btn btn-gradient-warning float-right" href="/page-commande-achat-edit.php"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> Commande</a>
                                </div>
                                <div class="col-7">
                                    <form method="POST" action="listeAchatCSV.php">
                                        <label>Mois</label>
                                        <div class="row">
                                            <div class="col-8">
                                                <select name="mois" class="form-control">
                                                    <option value="">--Choisir le mois --</option>
                                                    <option value="01">Janvier</option>
                                                    <option value="02">Février</option>
                                                    <option value="03">Mars</option>
                                                    <option value="04">Avril</option>
                                                    <option value="05">Mai</option>
                                                    <option value="06">Juin</option>
                                                    <option value="07">Juillet</option>
                                                    <option value="08">Août</option>
                                                    <option value="09">Septembre</option>
                                                    <option value="10">Octobre</option>
                                                    <option value="11">Novembre</option>
                                                    <option value="12">Décembre</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <button type="submit" name="genere_excel_achat" class="btn btn-gradient-warning "> Généré Excel</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-12 mt-5">
                                    <table class="table table-bordered table-hover data-besoin">
                                        <thead>
                                        <tr>
                                            <th class="no-wrap">#</th>
                                            <th class="no-wrap">N° Cde</th>
                                            <th class="no-wrap">Date commande</th>
                                            <th class="no-wrap">Montant</th>
                                            <th class="no-wrap">Date livraison prévu</th>
                                            <th class="no-wrap">Date livraison réelle</th>
                                            <th class="no-wrap text-right"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($commandeAchats as $value) { ?>
                                            <tr>
                                                <td><?php echo $value['co_id']; ?></td>
                                                <td><?php echo str_pad($value['co_id'], 6, "0", STR_PAD_LEFT); ?></td>
                                                <td><?php echo date('d/m/Y H:i:s', strtotime(str_replace('-','/', $value['co_date']))); ?></td>
                                                <td><?php echo $value['co_mtn']; ?></td>
                                                <td><?php if ($value['co_date_livraison_prevu']){ echo date('d/m/Y', strtotime(str_replace('-','/', $value['co_date_livraison_prevu']))); } ?></td>
                                                <td><?php if ($value['co_date_livraison_reelle']){ echo date('d/m/Y', strtotime(str_replace('-','/', $value['co_date_livraison_reelle']))); }?></td>
                                                <td class="text-center">
                                                    <a style="width: 130px;padding: 4px;" href="page-commande-achat-edit.php?id=<?php echo $value['co_id'];?>" class="btn btn-gradient-warning mb-2"><?php if ($value['co_date_livraison_reelle']){ echo 'Modifier';}else { echo 'Consulter';}?></a><br>
                                                    <?php if ($value['co_date_livraison_reelle']){ ?><a style="width: 130px;padding: 4px;" href="page-commande-achat-pdf.php?orderID=<?php echo $value['co_id'];?>" class="btn btn-gradient-warning mb-2">Facture</a> <?php }?>
                                                </td>
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


            <!-- Modal Commande -->
            <div class="modal fade" id="modalCommande" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                            <h5 class="modal-title" id="exampleModalLabel">Ajouter une commande client</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="#" method="POST">
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-md-12">
                                        <label>Client</label><br>

                                        <select name="client" class="form-control" >
                                            <option value="">--Choisir le client pour cette Commande--</option>
                                            <?php foreach ($clients as $value) {?>
                                                <option value="<?php echo $value['cl_id']; ?>"><?php echo $value['cl_nom']; ?></option>
                                            <?php } ?>


                                        </select>

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

	document.getElementById("comH").className += " active";


</script>

</body>
</html>