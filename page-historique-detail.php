<?php require 'script/page-historique-detail.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-newspaper-o"></i></span>Réalisation de <?php echo $realisations[0]['pi_libelle'];?>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="page-historique">Historique</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Historique de la réalisation</span></li>
                        </ul>
                    </nav>
                </div>

                <div class="card grid-margin">
                        <div class="card-body">
                            <h4 class="card-title">Détail de la pièce réalisé</h4><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Libelle de la gamme</label><br>
                                        <input type="text" class="form-control" maxlength="255" value="<?php echo $realisations[0]['ga_libelle'];?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Responsable </label><br>
                                        <input type="text" class="form-control" maxlength="255" value="<?php echo $realisations[0]['ou_prenom'].' '.$realisations[0]['ou_nom'];?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pièce </label><br>
                                        <input type="text" class="form-control" maxlength="255" value="<?php echo $realisations[0]['pi_libelle'];?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Référence de la pièce </label><br>
                                        <input type="text" class="form-control" maxlength="255" value="<?php echo $realisations[0]['pi_ref'];?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Réalisation -->
                <div class="card grid-margin" id="operation">
                    <div class="card-body">
                        <h4 class="card-title">Liste des réalisations</h4><br>
                        <div class="col-12 mt-5">
                            <table id="data-piece-utilise" class="table table-hover table-bordered datatable data-besoin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Libelle</th>
                                    <th>Machine</th>
                                    <th>Utilisateur</th>
                                    <th>Poste travail</th>
                                    <th>temps réalisation</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($realisations as $value) { ?>
                                    <tr id="item-<?php echo $value['re_id']; ?>">
                                        <td>
                                            <?php echo $value['re_id'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['re_libelle'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['ma_libelle'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['ou_prenom'].' '.$value['ou_nom'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['pt_libelle'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['re_temps_realisation'].' jours';?>
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
    <!-- page-body-wrapper ends -->
</div>

<?php require 'base/script.php'; ?>
<script src="assets/vendors/tinymce/tinymce.min.js"></script>
<script src="assets/vendors/tinymce/themes/modern/theme.js"></script>

<script type="text/javascript">

    document.getElementById("hisH").className += " active";


</script>

</body>
</html>