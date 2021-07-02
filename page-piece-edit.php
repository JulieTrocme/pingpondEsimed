<?php require 'script/page-piece-edit.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-newspaper-o"></i></span>Modifier une pièce
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="page-pieces">Pièces</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Modifier une pièce</span></li>
                        </ul>
                    </nav>
                </div>

                <!-- Detaill piece -->
                <div class="card grid-margin">
                    <form method="POST" action="#">
                        <div class="card-body">
                            <h4 class="card-title">Gestion de la pièce</h4><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Image</label><br>
                                        <label data-toggle="tooltip" title="Cliquer ici pour remplacer l'image" style="cursor: pointer;">
                                            <img src="<?php echo $piece['pi_image']; ?>" class="img-fluid img-thumbnail">
                                            <input type="file" class="sr-only cropInput" name="image" accept="image/*" data-shellid="<?php echo $piece['pi_id']; ?>" data-cropratio="1" data-choix='script/cropperPieceEdit.php' data-width = '600'>
                                        </label>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Libelle</label><br>
                                        <input type="text" name="pi_libelle" class="form-control" maxlength="255" placeholder="Nom de la pièce" value="<?php echo $piece['pi_libelle']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Type </label><br>
                                        <select class="form-control"  onchange="typePiece()" id="pieceSelect" name="pi_id_type" required>
                                            <?php
                                            foreach ($types as $value) {
                                                echo '<option value="'.$value['ty_id'].'"';
                                                if ($value['ty_id'] == $piece['pi_id_type']){
                                                    echo 'selected';
                                                }

                                                echo '>'.$value['ty_libelle'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label  id="prix"> <?php if ($piece['pi_id_type'] == 1){echo 'Prix d\'achat';}else{ echo 'Prix de vente';} ?></label><br>
                                        <input type="number" name="pi_prix" class="form-control" maxlength="255" placeholder="Prix de la pièce" step="0.01"  value="<?php echo $piece['pi_prix']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Stock</label><br>
                                        <input type="number" name="pi_stock" class="form-control" maxlength="255" placeholder="Stock de la pièce" step="1"  value="<?php echo $piece['pi_stock']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Réference</label><br>
                                        <input type="text" name="pi_ref" class="form-control" maxlength="255" placeholder="Référence de la pièce"  value="<?php echo $piece['pi_ref']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4" <?php if ($piece['pi_id_type'] == 1){echo 'style= "visibility:visible"';}else{ echo 'style= "visibility:hidden"';} ?> id="fournisseur">
                                    <div class="form-group">
                                        <label>Fournisseur</label><br>
                                        <input type="text" name="pi_fournisseur" class="form-control" maxlength="255" placeholder="Fournisseur de la pièce"  value="<?php echo $piece['pi_fournisseur']; ?>">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Gamme</label><br>
                                        <input type="text" class="form-control" disabled value="<?php echo $gamResp['ga_libelle']; ?>" placeholder="Aucune">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Responsable</label><br>
                                        <input type="text" class="form-control" disabled value="<?php if ($gamResp['ou_prenom'] && $gamResp['ou_nom']){echo $gamResp['ou_prenom'].' '.$gamResp['ou_nom'];} ?>" placeholder="Aucun">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-gradient-warning pull-right mr-3" name="edit_piece"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i> ENREGISTRER</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Piece utilisé -->
                <?php if ($piece['pi_id_type'] != 1) { ?>
                <div class="card grid-margin" id="fabrique">
                    <div class="card-body">
                        <h4 class="card-title">Gestion des pieces utilisé pour <?php echo $piece['pi_libelle'];?></h4><br>
                        <form method="POST" action="#">
                            <div class="row d-flex align-items-center">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pièce utilisé </label><br>
                                        <select class="form-control" name="pi_id_piece" required>
                                            <option value="">-- Choisir une des pièces utilisé --</option>
                                            <?php
                                            foreach ($pieces as $value) {
                                                $pasAfficher = 0;
                                                foreach ($pieceUtilises as $util){
                                                    if ($util['pi_id'] == $value['pi_id']){
                                                        $pasAfficher = 1;
                                                    }
                                                }
                                                if (!$pasAfficher){
                                                    echo '<option value="'.$value['pi_id'].'">'.$value['pi_libelle'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Quantité utilisé</label><br>
                                        <input type="number" name="pf_qte" class="form-control" maxlength="255" placeholder="Quantité utilisé" step="1" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-gradient-info pull-right mr-3" name="add_piece_fabrique"><i class="fa fa-plus mr-2" aria-hidden="true"></i> AJOUTER PIECE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-12 mt-5">
                            <table id="data-piece-utilise" class="table table-hover table-bordered datatable data-besoin">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Piece utilisé</th>
                                    <th>Qte</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($pieceUtilises as $value) { ?>
                                    <tr id="item-<?php echo $value['pi_id']; ?>">
                                        <td>
                                            <?php echo $value['pi_id'];?>
                                        </td>
                                        <td>
                                            <img src="<?php echo $value['pi_image'];?>">
                                        </td>
                                        <td>
                                            <?php echo $value['pi_libelle'];?>
                                        </td>
                                        <td>
                                            <?php echo $value['pf_qte'];?>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-gradient-info" data-toggle="modal" data-target="#modifUtil" style="width: 130px;padding: 4px;" onclick="updUtil(<?php echo $value['pf_id']; ?>,<?php echo $value['pf_qte']; ?>)">Modifier</button>
                                            <button style="width: 130px;padding: 4px;" data-toggle="modal" data-target="#del-util" class="btn btn-gradient-info" id="delUtil<?php echo $value['pf_id']; ?>" onclick="delUtil(<?php echo $value['pf_id']; ?>)">Supprimer</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php } ?>

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
                            <p class="lead">Confirmez-vous la suppression de cette pièce utilisé ?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light float-left" data-dismiss="modal">NON</button>
                            <form action="#" method="POST">
                                <input type="hidden" name="pu_id" id="pu_id" required>
                                <button type="submit" class="btn btn-gradient-info" name="delete_piece_utilise">OUI</button>
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
                            <h5 class="modal-title" id="exampleModalLabel">Modification de la quantité de cette pièce utilisé</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id_pu" name="id_pu" required>
                            <label>Qte :</label>
                            <input type="number"  step="1" id="pu_qte" class="form-control" name="pu_qte" placeholder="prix de l'unité" style="margin-bottom: 10px;" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-gradient-info"  name="update_qte">Valider</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Cropper image -->
        <div class="modal fade" id="modalCropp" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document" style="margin-top:30px;">
                <div class="modal-content">
                    <div class="modal-header" style="padding-bottom: 10px;">
                        <h5 class="modal-title" id="exampleModalLabel-2" >Découper l'image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding-top:10px;padding-bottom: 10px;">
                        <div class="img-container" style="max-height: 548px;">
                            <img id="imageCropper" src="#" class="img-fluid">
                        </div>
                    </div>
                    <div class="modal-footer" style="padding-top:10px;">
                        <button type="button" class="btn btn-light float-left" data-dismiss="modal">Quitter</button>
                        <button type="button" class="btn btn-gradient-warning" id="crop1">Valider</button>
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

    function typePiece(){
        var selectElmt2 = document.getElementById('pieceSelect');
        var idPieceSelect = selectElmt2.options[selectElmt2.selectedIndex].value;

        if (idPieceSelect == 1){

            document.getElementById('fournisseur').style.visibility = "visible"
            document.getElementById('prix').innerHTML = "Prix d'achat"


        } else if (idPieceSelect == 2){

            document.getElementById('fournisseur').style.visibility = "hidden"
            document.getElementById('prix').innerHTML = "Prix de vente"

        } else if (idPieceSelect == 3){

            document.getElementById('fournisseur').style.visibility = "hidden"
            document.getElementById('prix').innerHTML = "Prix de vente"

        }

    }

    function delUtil(id) {
        document.getElementById('pu_id').value = id;
    }


    function updUtil(id,qte){
        document.getElementById('id_pu').value = id;
        document.getElementById('pu_qte').value = qte;
    }


    $(document).ready(function () {

        var image = document.getElementById('imageCropper');
        var $modal = $('#modalCropp');
        var cropper;
        var imageName = '';
        var shellId = '';
        var ratio = '';
        var choixCrop ='';
        var width = '';

        let elementsArray = document.querySelectorAll(".cropInput");

        elementsArray.forEach(function(elem) {
            elem.addEventListener("change", function(e) {
                var files = e.target.files;

                if (elem.files.length > 0) {
                    // RUN A LOOP TO CHECK EACH SELECTED FILE.
                    for (var i = 0; i <= elem.files.length - 1; i++)
                    {
                        imageName = elem.files.item(i).name;
                    }
                }

                var done = function (url) {
                    elem.value = '';
                    image.src = url;
                    shellId = elem.dataset.shellid;
                    ratio = parseFloat(elem.dataset.cropratio);
                    choixCrop = elem.dataset.choix;
                    width = elem.dataset.width;
                    $modal.modal('show');
                };

                var reader;
                var file;
                var url;

                if (files && files.length > 0) {
                    file = files[0];
                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                dragMode: 'move',
                aspectRatio: ratio,
                initialAspectRatio: ratio,
                autoCropArea: 0.9,
                restore: false,
                guides: false,
                cropBoxMovable: false,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                checkOrientation: false,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        document.getElementById('crop1').addEventListener('click', function () {
            var canvas;

            $modal.modal('hide');

            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    width: width,
                    fillColor: '#fff'
                });

                canvas.toBlob(function (blob) {
                    var formData = new FormData();

                    formData.append('avatar64', canvas.toDataURL("image/jpeg"), );
                    formData.append('avatar64name', imageName);
                    formData.append('pi_id', shellId);


                    $.ajax(choixCrop, {
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,

                        success: function () {
                            location.reload();
                        }

                    });

                });
            }
        });

    });
</script>

</body>
</html>