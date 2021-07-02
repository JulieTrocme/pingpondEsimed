<?php require 'script/page-commande-achat-edit.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-newspaper-o"></i></span>Modifier commande d'achat N°<?php echo str_pad($id, 6, "0", STR_PAD_LEFT); ?>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="page-commande">Commandes</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Modifier la commande d'achat</span></li>
                        </ul>
                    </nav>
                </div>

                <!-- commande -->
                <div class="card grid-margin">
                    <form method="POST" action="#">
                        <div class="card-body">
                            <h4 class="card-title">Gestion de la commande d'achat</h4><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date de livraison prévue</label><br>
                                        <input name="datePrevue" class="datepicker form-control" <?php if ($commande['co_date_livraison_reelle']){ echo 'disabled';}?> data-date-format="dd/mm/yyyy" value="<?php if ($commande['co_date_livraison_prevu']) { echo date('d/m/Y ', strtotime(str_replace('-','/', $commande['co_date_livraison_prevu'])));}?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date de livraison réelle</label><br>
                                        <input name="dateReelle" class="datepicker form-control" <?php if ($commande['co_date_livraison_reelle']){ echo 'disabled';}?> data-date-format="dd/mm/yyyy" value="<?php if ($commande['co_date_livraison_reelle']) { echo date('d/m/Y ', strtotime(str_replace('-','/', $commande['co_date_livraison_reelle'])));}?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!$commande['co_date_livraison_reelle']){ ?>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-gradient-warning pull-right mr-3" name="edit_commande"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i> ENREGISTRER</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                    </form>
                </div>

                <!-- Ligne commande -->
                <div class="card grid-margin">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title float-left">Récapitulatif de la commande</h4>
                                <?php if (!$commande['co_date_livraison_reelle']){ ?>
                                    <button type="button" class="btn btn-gradient-warning float-right" style="margin-left:10px;" data-toggle="modal" data-target="#modalPiece">
                                        <i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> Pièce</button>
                                <?php } ?>
                            </div>
                            <div class="col-12 mt-5">
                                <table id="data-piece-utilise" class="table table-hover table-bordered datatable data-besoin">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th>Pièce</th>
                                        <th>Prix unitaire</th>
                                        <th>Quantité</th>
                                        <th>Prix total</th>
                                        <?php if (!$commande['co_date_livraison_reelle']){ ?><th></th><?php } ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($lignecommande as $value) { ?>
                                        <tr id="item-<?php echo $value['lc_id']; ?>">
                                            <td>
                                                <?php echo $value['lc_id'];?>
                                            </td>
                                            <td>
                                                <img style="width: 150px;height: auto;border-radius: 0;" src="<?php echo $value['pi_image'];?>">
                                            </td>
                                            <td>
                                                <?php echo $value['pi_libelle'].'<br>'.$value['pi_ref'];?>
                                            </td>
                                            <td>
                                                <?php echo number_format($value['lc_mtn'], 2).' €';?>
                                            </td>
                                            <td>
                                                <?php echo $value['lc_qte'];?>
                                            </td>
                                            <td>
                                                <?php echo number_format(($value['lc_qte']*$value['lc_mtn']), 2).' €';?>
                                            </td>
                                            <?php if (!$commande['co_date_livraison_reelle']){ ?>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-gradient-info" data-toggle="modal" data-target="#modifUtil" style="width: 130px;padding: 4px;" onclick="updUtil(<?php echo $value['lc_id']; ?>,<?php echo $value['lc_qte']; ?>)">Modifier</button>
                                                    <button style="width: 130px;padding: 4px;" data-toggle="modal" data-target="#del-util" class="btn btn-gradient-info" id="delUtil<?php echo $value['lc_id']; ?>" onclick="delUtil(<?php echo $value['lc_id']; ?>)">Supprimer</button>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-7 mt-5"></div>
                            <div class="col-5 mt-5">
                                <div class="table-responsive">
                                    <table id="data_acti" class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th class="no-wrap"></th>
                                            <th class="no-wrap"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <!--<tr>
                                            <td>TOTAL HT : </td>
                                            <td class="text-right"></td>
                                        </tr>
                                        <tr>
                                            <td>TOTAL TVA : </td>
                                            <td class="text-right"></td>
                                        </tr>
                                        <tr>
                                            <td>FRAIS DE PORT : </td>
                                            <td class="text-right"></td>
                                        </tr>-->
                                        <tr>
                                            <td>TOTAL TTC : </td>
                                            <td class="text-right" style="font-weight: bold;"><?php echo number_format($commande['co_mtn'], 2). ' €';?></td>
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


        <div class="modal fade" id="del-util" tabindex="-1" role="dialog">
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
                            <p class="lead">Confirmez-vous la suppression de cette pièce ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light float-left" data-dismiss="modal">NON</button>
                            <form action="#" method="POST">
                                <input type="hidden" name="pu_id" id="pu_id" required>
                                <button type="submit" class="btn btn-gradient-info" name="delete_piece">OUI</button>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="modifUtil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="#">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modification de la quantité de cette pièce</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id_pu" name="id_pu" required>
                            <label>Qte :</label>
                            <input type="number"  step="1" id="pu_qte" class="form-control" name="pu_qte" placeholder="quantité de la pièce" style="margin-bottom: 10px;" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-gradient-info"  name="update_qte">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal commande -->
        <div class="modal fade" id="modalPiece" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter des pièces dans le commande</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="POST">
                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <?php foreach ($pieces as $value) { ?>

                                        <input type="checkbox" class="checkboxPiece" id="<?php echo 'piece'.$value['pi_id'];?>" name="pieces[]" value="<?php echo $value['pi_id'];?>">
                                        <label class="labelPiece" for="<?php echo 'piece'.$value['pi_id'];?>">
                                            <img style="width: 150px;" src="<?php echo $value['pi_image'];?>"><br>
                                            <h3><?php echo $value['pi_libelle'];?><br><?php echo $value['pi_ref'];?></h3>
                                            <p> Prix unitaire :  <?php echo $value['pi_prix']?></p>
                                        </label>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                            <button type="submit" name="add_ligne_commande" class="btn btn-success pull-right">Ajouter</button>
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

<script type="text/javascript">

    document.getElementById("comH").className += " active";

    $('.datepicker').datepicker({
        startDate: '+1d'
    });

    function delUtil(id) {
        document.getElementById('pu_id').value = id;
    }

    function updUtil(id,qte){
        document.getElementById('id_pu').value = id;
        document.getElementById('pu_qte').value = qte;
    }


</script>

</body>
</html>