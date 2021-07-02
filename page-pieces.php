<?php require 'script/page-pieces.php'; ?>
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
							<span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-podcast"></i></span>Pages des produits 
						</h3>
						<nav aria-label="breadcrumb">
							<ul class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page">Gestion des produits</li>
							</ul>
						</nav>
					</div>

                    <div class="card grid-margin">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title float-left">Gestion des pièces</h4>
                                    <a href="page-piece-add" class="btn btn-gradient-warning float-right" style="margin-left: 10px;"><i class="fa fa-plus mr-2" aria-hidden="true"></i> AJOUTER</a>
                                </div>
                                <div class="col-12 mt-5">
                                    <table class="table table-hover table-bordered data-besoin">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>Libelle</th>
                                            <th>Référence</th>
                                            <th>Type</th>
                                            <th>Prix</th>
                                            <th>Stock</th>
                                            <th>Gamme</th>
                                            <th>Responsable</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($pieces as $value) { ?>
                                            <tr>
                                                <td><?php echo $value['pi_id'];?></td>
                                                <td><img src="<?php echo $value['pi_image'];?>" style="width: 100px;height: auto;border-radius: 0;"></td>
                                                <td><?php echo $value['pi_libelle'];?></td>
                                                <td><?php echo $value['pi_ref'];?></td>
                                                <td><?php echo $value['ty_libelle'];?></td>
                                                <td><?php echo $value['pi_prix'];?></td>
                                                <td><?php echo $value['pi_stock'];?></td>
                                                <td><?php echo $value['ga_libelle'];?></td>
                                                <td><?php echo $value['ou_prenom'].' '.$value['ou_nom'];?></td>
                                                <td class="text-center">
                                                    <a style="width: 130px;padding: 4px;" href="page-piece-edit.php?id=<?php echo $value['pi_id']; ?>" class="btn btn-gradient-warning mb-2">Modifier</a><br>
                                                    <button style="width: 130px;padding: 4px;" data-toggle="modal" data-target="#del-piece" class="btn btn-gradient-warning" id="delpiece<?php echo $value['pi_id']; ?>" onclick="delpiece(<?php echo $value['pi_id']; ?>)">Supprimer</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card grid-margin">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="card-title float-left">Gestion des gammes</h4>
                                    <a href="page-gamme-add" class="btn btn-gradient-warning float-right" style="margin-left: 10px;"><i class="fa fa-plus mr-2" aria-hidden="true"></i> AJOUTER</a>
                                </div>
                                <div class="col-12 mt-5">
                                    <table class="table table-hover table-bordered data-besoin">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Libelle</th>
                                            <th>Responsable</th>
                                            <th>Piece</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($gammes as $value) { ?>
                                            <tr>
                                                <td><?php echo $value['ga_id'];?></td>

                                                <td><?php echo $value['ga_libelle'];?></td>
                                                <td><?php echo $value['ou_prenom'].' '.$value['ou_nom'];?></td>
                                                <td><?php echo $value['pi_libelle'];?></td>
                                                <td class="text-center">
                                                    <a style="width: 130px;padding: 4px;" href="page-realisation.php?id=<?php echo $value['ga_id']; ?>" class="btn btn-gradient-warning mr-2">Réalisé</a>
                                                    <a style="width: 130px;padding: 4px;" href="page-gamme-edit.php?id=<?php echo $value['ga_id']; ?>" class="btn btn-gradient-warning mr-2">Modifier</a>
                                                    <button style="width: 130px;padding: 4px;" data-toggle="modal" data-target="#del-gamme" class="btn btn-gradient-warning" id="delgamme<?php echo $value['ga_id']; ?>" onclick="delgamme(<?php echo $value['ga_id']; ?>)">Supprimer</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="del-piece" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <form method="POST" action="#">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel-2">Attention !</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="lead">Confirmez-vous la suppression de cette piece ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light float-left" data-dismiss="modal">NON</button>
                                        <form action="#" method="POST">
                                            <input type="hidden" name="pi_id" id="pi_id" required>
                                            <button type="submit" class="btn btn-gradient-info" name="delete_piece">OUI</button>
                                        </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal fade" id="del-gamme" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <form method="POST" action="#">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel-2">Attention !</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="lead">Confirmez-vous la suppression de cette gamme ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light float-left" data-dismiss="modal">NON</button>
                                        <form action="#" method="POST">
                                            <input type="hidden" name="ga_id" id="ga_id" required>
                                            <button type="submit" class="btn btn-gradient-info" name="delete_gamme">OUI</button>
                                        </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
			</div>
		</div>
		<!-- page-body-wrapper ends -->
	</div>

	<?php require 'base/script.php'; ?>

	<script type="text/javascript">
		document.getElementById("besH").className += " active";


        function delpiece(id) {
            document.getElementById('pi_id').value = id;
        }


        function delgamme(id) {
            document.getElementById('ga_id').value = id;
        }

	</script>

</body>
</html>