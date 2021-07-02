<?php require 'script/page-machine-edit.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-newspaper-o"></i></span>Modifier une machine
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="page-machines">Machines</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Modifier une machine</span></li>
                        </ul>
                    </nav>
                </div>

                <!-- machine -->
                <div class="card grid-margin">
                    <form method="POST" action="#">
                        <div class="card-body">
                            <h4 class="card-title">Gestion de la machine</h4><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Libelle</label><br>
                                        <input type="text" name="ma_libelle" class="form-control" maxlength="255" placeholder="Nom de la machine" value="<?php echo $machine['ma_libelle'];?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Postes </label><br>
                                        <?php foreach ($postes as $value) {
                                            $check = 0;
                                            foreach ($postesUtilises as $util){
                                                if ($util['pt_id'] == $value['pt_id']){
                                                    $check = 1;
                                                }
                                            }
                                            ?>

                                            <input type="checkbox" id="<?php echo 'poste'.$value['pt_id'];?>" name="poste[]" value="<?php echo $value['pt_id'];?>" <?php if ($check == 1) {echo 'checked';}?>>
                                            <label for="<?php echo 'poste'.$value['pt_id'];?>"> <?php echo $value['pt_libelle'];?></label><br>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-gradient-warning pull-right mr-3" name="edit_machine"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i> ENREGISTRER</button>
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

    document.getElementById("macH").className += " active";

</script>

</body>
</html>