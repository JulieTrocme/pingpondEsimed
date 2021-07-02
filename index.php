<?php require 'script/index.php'; ?>
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
							<span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="mdi mdi-home"></i></span>Accueil 
						</h3>
						<nav aria-label="breadcrumb">
							<ul class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page">Gestion de la page d'accueil</li>
							</ul>
						</nav>
					</div>


					<!-- HEADER -->
		            <div class="card grid-margin">

							<div class="card-body">
								<div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"><h2> Bonjour <?php echo $_SESSION['admin_login']['ou_prenom'].' '.$_SESSION['admin_login']['ou_nom']?></h2></div>
                                    <div class="col-md-4"></div>

								</div>			
							</div>
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

</body>
</html>