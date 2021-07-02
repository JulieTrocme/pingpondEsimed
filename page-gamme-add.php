<?php require 'script/page-gamme-add.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-newspaper-o"></i></span>Ajouter une gamme
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="page-pieces">Pieces</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Ajouter une gamme</span></li>
                        </ul>
                    </nav>
                </div>

                <!-- Gamme -->
                <div class="card grid-margin">
                    <form method="POST" action="#">
                        <div class="card-body">
                            <h4 class="card-title">Gestion de la gamme</h4><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Libelle</label><br>
                                        <input type="text" name="pi_libelle" class="form-control" maxlength="255" placeholder="Nom de la gamme" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Responsable </label><br>
                                        <select class="form-control" name="pi_id_responsable" required>
                                            <option value="">-- Choisir le responsable de la gamme --</option>
                                            <?php
                                            foreach ($responsables as $value) {
                                                echo '<option value="'.$value['ou_id'].'">'.$value['ou_prenom'].' '.$value['ou_nom'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pièce </label><br>
                                        <select class="form-control" name="pi_id_piece" required>
                                            <option value="">-- Choisir la pièce de la gamme --</option>
                                           <?php
                                            foreach ($pieces as $value) {
                                                $prise = 0;
                                                foreach ($gammes as $ga){
                                                    if ($ga['ga_id_piece'] == $value['pi_id']){
                                                        $prise = 1;
                                                    }
                                                }
                                                if (!$prise){
                                                    echo '<option value="'.$value['pi_id'].'">'.$value['pi_libelle'].'</option>';
                                                }

                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-gradient-warning pull-right mr-3" name="add_piece"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i> ENREGISTRER</button>
                                    </div>
                                </div>
                            </div>
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

    document.getElementById("besH").className += " active";

</script>

</body>
</html>