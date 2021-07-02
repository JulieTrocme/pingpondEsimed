<?php require 'script/commande-fiche.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<?php require 'base/head.php'; ?>

<body>
	<div class="container-scroller">

		<div class="container-fluid page-body-wrapper">

			<div class="main-panel" style="width: 100%;">
				<div class="content-wrapper">

					<div class="page-header">
						<h3 class="page-title">
							<span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="mdi mdi-home"></i></span>Commande n° : <?php echo str_pad($cde['Cde_ID'], 6, "0", STR_PAD_LEFT); ?>
						</h3>
						<nav aria-label="breadcrumb">
							<ul class="breadcrumb">
								<li class="breadcrumb-item active" aria-current="page">Détail commande</li>
							</ul>
						</nav>
					</div>

					<!-- info commande -->
					<div class="card grid-margin">
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<h4 class="card-title float-left">Info commande</h4>
								</div>

								<div class="col-3 mt-3">
									<h4>Adresse de Facturation</h4><br>
									<p>ALTEN<br>Monsieur Frédéric MOUTON<br>40 Avenue André Morizet<br>92513 Boulogne-Billancourt CEDEX</p>				         
								</div>

								<div class="col-3 mt-3">
									<h4>Adresse de livraison</h4><br>
									<p><?php 
										echo $adresseLivraison['ad_surname'].' '.$adresseLivraison['ad_name'].'<br>';
										echo $adresseLivraison['ad_address_1'].'<br>';
										if (!empty($adresseLivraison['ad_address_2'])) {
											echo $adresseLivraison['ad_address_2'].'<br>';
										}
										echo $adresseLivraison['ad_cp'].' '.$adresseLivraison['ad_city']. ' - '.$adresseLivraison['nom_fr_fr'].'<br>'.$adresseLivraison['ad_tel'];
									 ?></p>				         
								</div>
								<div class="col-3 mt-3">
									<h4>Client</h4><br>
									<?php echo $cde['us_surname'].' '.$cde['us_name']; ?><br>
									<?php echo $cde['us_email']; ?><br>
									<?php echo $cde['com_libelle']; ?>
								</div>
								<div class="col-3 mt-3">
									<h4>Date Livraison</h4><br>
									<?php echo date('d/m/Y', strtotime(str_replace('-','/', $cde['Cde_Date_Liv']))); ?>
								</div>
							</div>			
						</div>
		            </div>

					<!-- tableau client -->
					<div class="card grid-margin">
						<div class="card-body">
							<h4 class="card-title">Détail commande</h4><br>
							
							<!-- SLIDES -->
							<div class="row" >
								<div class="col-12 mt-5 mb-5 table-responsive">
				                    <table class="table table-bordered table-hover">
				                        <thead>
				                            <tr>
				                                <th class="no-wrap">Image produit</th>
				                                <th class="no-wrap">Nom produit</th>
				                                <th class="no-wrap">Prix unitaire HT</th>
				                                <th class="no-wrap">Quantité</th>
				                                <th class="no-wrap">Total HT</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <?php foreach ($articles as $article) { 
				                            	$prixUnitaire = $article['CL_Mtn'] / $article['CL_Qte']?> 
				                            <tr>
				                            	<td><img src="<?php echo $article['be_image_prod']; ?>"/></td>
				                            	<td><?php echo $article['be_content_titre']; ?></td>
				                            	<td style="font-family:Arvo;"><?php echo $prixUnitaire.' €'; ?></td>
				                            	<td style="font-family:Arvo;"><?php echo $article['CL_Qte']; ?></td>
				                            	<td style="font-family:Arvo;"><?php echo $article['CL_Mtn'].' €'; ?></td>
				                            </tr>
				                            <?php } ?>
				                        </tbody>
				                    </table>    
								</div>
								<div class="col-md-6">
									<h2 class="m-text25 p-t-15 p-b-10">Commentaire</h2>
									<p><?php echo $cde['Cde_Com']; ?></p>
								</div>
								<div class="col-md-6 mt-3 table-responsive">

				                  <h2 class="m-text25 p-t-15 p-b-10">Total panier</h2>
				                  <table class="table mt-4">
				                      <tbody>

				                        <tr>
					                          <td><p class="bold text-left">TOTAL HT :</p></td>
					                          <td class="text-right">
					                          	<p class="lead cart_totals-price-HT" style="font-family:Arvo;"> 
					                          		<?php $totalHT = 0; 
					                          		foreach ($articles as $article) {
					                          			$totalHT = $totalHT + $article['CL_Mtn'];
					                          		}
					                          		echo $totalHT.' €';?>

				                      			</p>
				                      		</td>
				                        </tr>

				                        <tr>
					                          <td><p class="bold text-left">TOTAL TVA :</p></td>
					                          <td class="text-right">
					                          	<p class="lead cart_totals-price-HT" style="font-family:Arvo;"> 
					                          		<?php /*$totalHT = 0; 
					                          		foreach ($articles as $article) {
					                          			$totalHT = $totalHT + $article['CL_Mtn'];
					                          		}*/
					                          		echo number_format(round($totalHT * 1.2 - $totalHT, 2), 2).' €';?>

				                      			</p>
				                      		</td>
				                        </tr>

				                        <tr>
											<td><p class="bold text-left">TOTAL ECO TAXE :</p></td>
											<td class="text-right">
					                          	<p class="lead cart_totals-price-ECO-TAXE" style="font-family:Arvo;"> 
					                          	<?php $totalEcoTaxe = 0; 
						                          		foreach ($articles as $article) {
						                          			$totalEcoTaxe = $totalEcoTaxe + $article['CL_MtnEcoTaxe'];
						                          		}
						                          		echo $totalEcoTaxe.' €';?>
					                          	</p>
				                      		</td>
				                        </tr>
				                        <tr>
				                          <td><p class="bold text-left">TOTAL TTC :</p></td>
				                          <td class="text-right"><p class="lead cart_totals-price" style="font-family:Arvo;"> <?php $totalTTC = number_format(round($totalHT * 1.2 + $totalEcoTaxe, 2), 2); echo $totalTTC.' €'  ?> </p></td>

				                        </tr>
				                          
				                      </tbody>
				                  </table>
				                </div>
							</div>
						</div>
					</div>
		        </div>
			</div>
		</div>
		<!-- page-body-wrapper ends -->
	</div>

	<?php require 'base/script.php'; ?>

	<script type="text/javascript">			
		window.print();
	</script>

</body>
</html>