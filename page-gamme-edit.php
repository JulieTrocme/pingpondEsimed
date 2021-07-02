<?php require 'script/page-gamme-edit.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-newspaper-o"></i></span>Modifier une gamme
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="page-pieces">Pieces</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Modifier une gamme</span></li>
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
                                        <input type="text" name="ga_libelle" class="form-control" maxlength="255" placeholder="Nom de la gamme" value="<?php echo $gamme['ga_libelle'];?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Responsable </label><br>
                                        <select class="form-control" name="ga_id_responsable" required>
                                            <option value="">Choisir le responsable de la gamme</option>
                                            <?php
                                            foreach ($responsables as $value) {
                                                echo '<option value="'.$value['ou_id'].'"';
                                                if ($value['ou_id'] == $gamme['ou_id']){
                                                    echo 'selected';
                                                }

                                                echo '>'.$value['ou_prenom'].' '.$value['ou_nom'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pièce </label><br>
                                        <select class="form-control" name="ga_id_piece" required>
                                            <option value="">Choisir la pièce de la gamme</option>
                                            <?php
                                            foreach ($pieces as $value) {
                                                $prise = 0;
                                                foreach ($gammes as $ga) {
                                                    if ($ga['ga_id_piece'] == $value['pi_id'] && $value['pi_id'] != $gamme['pi_id']) {
                                                        $prise = 1;
                                                    }
                                                }
                                                if (!$prise) {
                                                    echo '<option value="' . $value['pi_id'] . '"';
                                                    if ($value['pi_id'] == $gamme['pi_id']) {
                                                        echo 'selected';
                                                    }
                                                    echo '>' . $value['pi_libelle'] . '</option>';
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
                                        <button type="submit" class="btn btn-gradient-warning pull-right mr-3" name="edit_gamme"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i> ENREGISTRER</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Operation de la gamme -->
                <div class="card grid-margin" id="operation">
                    <div class="card-body">
                        <h4 class="card-title">Gestion des opérations</h4><br>
                        <button type="button" class="btn btn-gradient-warning mr-5" style="margin-left:10px;" data-toggle="modal" data-target="#modalNouvelOp"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> Nouvelle opération</button>
                        <button type="button" class="btn btn-gradient-warning" style="margin-left:10px;" data-toggle="modal" data-target="#modalAncienOp"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> Ancienne opération</button>
                        <div class="col-12 mt-5">
                            <table id="data-piece-utilise" class="table table-hover table-bordered datatable data-besoin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Libelle</th>
                                    <th>Machine</th>
                                    <th>Poste travail</th>
                                    <th>temps réalisation</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($operationUtilises as $value) { ?>
                                    <tr id="item-<?php echo $value['op_id']; ?>">
                                        <td>
                                            <?php echo $value['op_id'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['op_libelle'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['ma_libelle'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['pt_libelle'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['op_temps_realisation'].' jours';?>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-gradient-info" data-toggle="modal" data-target="#modifOperation" style="width: 130px;padding: 4px;" onclick="updOperation(<?php echo $gamme['ou_id'];?>,<?php echo $value['op_id']; ?>,'<?php echo $value['op_libelle']; ?>',<?php echo $value['op_id_machine']; ?>,<?php echo $value['op_id_poste']; ?>,<?php echo $value['op_temps_realisation']; ?>)">Modifier</button>
                                            <button style="width: 130px;padding: 4px;" data-toggle="modal" data-target="#del-operation" class="btn btn-gradient-info" id="delOperation<?php echo $value['op_id']; ?>" onclick="delOperation(<?php echo $value['op_id']; ?>)">Supprimer</button>
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

        <!-- Modal ajout operation -->
        <div class="modal fade" id="modalNouvelOp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter opération</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Libelle opération</label><br>
                                    <input type="text" name="op_libelle" class="form-control" maxlength="255" placeholder="Ex : Opération 1" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Temps de réalisation de l'opération (en jours)</label><br>
                                    <input type="number" name="op_temps" class="form-control" maxlength="255" placeholder="Ex : 4" step="1" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Machine pour l'opération</label>
                                    <select name="op_machine" class="form-control" id="machineSelect"  onchange="getPosteTravail(<?php echo $gamme['ou_id'];?>,'machineSelect','posteSelect',0)" maxlength="200" style="color:black;" required>
                                        <option value="">Choisir la machine pour cette opération</option>
                                        <?php foreach ($machines as $value) {?>
                                            <option value="<?php echo $value['ma_id']; ?>"><?php echo $value['ma_libelle']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Poste pour l'opération</label>
                                    <select name="op_poste" id="posteSelect" class="form-control" maxlength="200" style="color:black;" required>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                            <button type="submit" name="add_new_operation" class="btn btn-success pull-right">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal ancienne opération -->
        <div class="modal fade" id="modalAncienOp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <?php if ($nbOperations > 0 ){
                                    foreach ($operations as $value) {
                                        $check = 0;
                                        foreach ($operationUtilises as $util){
                                            if ($util['op_id'] == $value['op_id']){
                                                $check = 1;
                                            }
                                        }
                                        ?>

                                        <input type="checkbox" id="<?php echo 'operation'.$value['op_id'];?>" name="operation[]" value="<?php echo $value['op_id'];?>" <?php if ($check == 1) {echo 'checked';}?>>
                                        <label for="<?php echo 'operation'.$value['op_id'];?>"> <?php echo $value['op_libelle'];?></label><br>
                                    <?php }
                                }  else {
                                    echo '<p>Aucune opération disponible</p>';
                                }?>

                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                            <button type="submit" name="add_operation" class="btn btn-success pull-right">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="del-operation" tabindex="-1" role="dialog">
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
                            <p class="lead">Confirmez-vous la suppression de cette opération pour cette gamme ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light float-left" data-dismiss="modal">NON</button>
                            <form action="#" method="POST">
                                <input type="hidden" name="op_id" id="op_id" required>
                                <button type="submit" class="btn btn-gradient-info" name="delete_operation">OUI</button>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="modal fade" id="modifOperation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="#">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modification de cette opération</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id_op" name="id_op" required>
                            <div class="form-group col-md-6">
                                <label>Libelle opération</label><br>
                                <input type="text" id="op_libelle" name="op_libelle" class="form-control" maxlength="255" placeholder="Ex : Opération 1" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Temps de réalisation de l'opération (en jours)</label><br>
                                <input type="number" id="op_temps" name="op_temps" class="form-control" maxlength="255" placeholder="Ex : 4" step="1" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Machine pour l'opération</label>
                                <select name="op_machine" id="machineSelectModif" onchange="getPosteTravail('machineSelectModif','posteSelectModif','id_op')" class="form-control" maxlength="200" style="color:black;" required>
                                    <?php foreach ($machines as $value) {?>
                                        <option id="machine-<?php echo $value['ma_id'];?>" value="<?php echo $value['ma_id']; ?>"><?php echo $value['ma_libelle']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Poste pour l'opération</label>
                                <select name="op_poste" id="posteSelectModif" class="form-control" maxlength="200" style="color:black;" required>

                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-gradient-info"  name="update_operation">Valider</button>
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

    function delOperation(id) {
        document.getElementById('op_id').value = id;
    }


    function updOperation(idUser,id,libelle,machine,poste,rea){

        document.getElementById('id_op').value = id;
        document.getElementById('op_libelle').value = libelle;
        document.getElementById('op_temps').value = rea;
        document.getElementById('machineSelectModif').value = machine;

        getPosteTravail(idUser,'machineSelectModif','posteSelectModif',id)

    }


    function getPosteTravail(idUser,nomSelect,nom2Select,idOp){

        var selectElmt2 = document.getElementById(nomSelect);
        var idMachineSelect = selectElmt2.options[selectElmt2.selectedIndex].value;

        if (idOp == 'id_op'){
            idOp = document.getElementById('id_op').value
        }

        $.ajax({
            url: "script/listePosteTravail.php",
            type: 'post',
            data: 'machine=' + idMachineSelect + '&idOp='+idOp +'&idUser='+idUser,
            success: function(data){
                    $("#"+nom2Select).html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });

    }

</script>

</body>
</html>