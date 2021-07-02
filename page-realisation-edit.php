<?php require 'script/page-realisation-edit.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-newspaper-o"></i></span>Réalisation de <?php echo $gamme['ga_libelle']; ?>
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="page-pieces">Atelier</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Modifier la réalisation</span></li>
                        </ul>
                    </nav>
                </div>

                <!-- Réalisation -->
                <div class="card grid-margin" id="operation">
                    <div class="card-body">
                        <h4 class="card-title">Gestion des opérations réalisé</h4><br>
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
                                    <th></th>
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
                                        <td class="text-center">
                                            <button type="button" class="btn btn-gradient-info" data-toggle="modal" data-target="#modifOperation" style="width: 130px;padding: 4px;" onclick="updOperation(<?php echo $gamme['ou_id']; ?>,<?php echo $value['re_id']; ?>,'<?php echo $value['re_libelle']; ?>',<?php echo $value['re_id_machine']; ?>,<?php echo $value['re_id_poste']; ?>,<?php echo $value['re_temps_realisation']; ?>)">Modifier</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modifOperation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form method="POST" action="#">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modification de cette réalisation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="re_id" name="re_id" required>
                                    <div class="form-group col-md-6">
                                        <label>Temps de réalisation (en jours)</label><br>
                                        <input type="number" id="re_temps" name="re_temps" class="form-control" maxlength="255" placeholder="Ex : 4" step="1" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Ouvrier qui a réalisé l'opération</label>
                                        <select name="re_ouvrier" id="ouvrierSelectModif" onchange="getMachine()" class="form-control" maxlength="200" style="color:black;" required>
                                            <option value="">--Choisir l'ouvrier qui a fait l'opération--</option>
                                            <?php foreach ($ouvriers as $value) {?>
                                                <option id="ouvrier-<?php echo $value['ou_id'];?>" value="<?php echo $value['ou_id']; ?>"><?php echo $value['ou_prenom'].' '.$value['ou_nom']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Machine pour l'opération réalisé</label>
                                        <select name="re_machine" id="machineSelectModif" onchange="getPosteTravail('machineSelectModif','posteSelectModif','re_id')" class="form-control" maxlength="200" style="color:black;" required>
                                            <?php foreach ($machines as $value) {?>
                                                <option id="machine-<?php echo $value['ma_id'];?>" value="<?php echo $value['ma_id']; ?>"><?php echo $value['ma_libelle']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Poste pour l'opération réalisé</label>
                                        <select name="re_poste" id="posteSelectModif" class="form-control" maxlength="200" style="color:black;" required>

                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-gradient-info"  name="update_realisation">Valider</button>
                                </div>
                            </form>
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

    document.getElementById("besH").className += " active";


    function updOperation(idUser,id,libelle,machine,poste,temps){

        document.getElementById('re_id').value = id;
        document.getElementById('re_temps').value = temps;
        document.getElementById('machineSelectModif').value = machine;

        getPosteTravail('machineSelectModif','posteSelectModif',id)

    }

    function getMachine(){
        var selectElmt2 = document.getElementById('ouvrierSelectModif');
        var idouvrierSelectModif = selectElmt2.options[selectElmt2.selectedIndex].value;

        $.ajax({
            url: "script/listeMachine.php",
            type: 'post',
            data: 'idUser='+idouvrierSelectModif,
            success: function(data){
                $("#machineSelectModif").html(data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    }


    function getPosteTravail(nomSelect,nom2Select,idOp){

        var selectElmt2 = document.getElementById(nomSelect);
        var idMachineSelect = selectElmt2.options[selectElmt2.selectedIndex].value;


        var selectElmt3 = document.getElementById('ouvrierSelectModif');
        var idUser = selectElmt3.options[selectElmt3.selectedIndex].value;

        if (idOp == 're_id'){
            idOp = document.getElementById('re_id').value
        }
        $.ajax({
            url: "script/listePosteTravailRea.php",
            type: 'post',
            data: 'machine=' + idMachineSelect + '&idOp='+idOp+'&idUser='+idUser,
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