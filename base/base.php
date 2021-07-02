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
							<span class="page-title-icon bg-gradient-primary text-white mr-2"><i class="mdi mdi-home"></i></span>Dashboard 
						</h3>
						<nav aria-label="breadcrumb">
							<ul class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page">
									<span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
								</li>
							</ul>
						</nav>
					</div>

					<div class="row">
						<!--Content here-->
					</div>

				</div>

				<?php require 'base/footer.php'; ?>

			</div>

		</div>
		<!-- page-body-wrapper ends -->
	</div>

	<?php require 'base/script.php'; ?>
</body>
</html>