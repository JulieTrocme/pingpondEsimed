<?php require 'script/page-piece-add.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-newspaper-o"></i></span>Ajouter une pièce
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page"><a href="page-pieces">Pièces</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Ajouter une pièce</span></li>
                        </ul>
                    </nav>
                </div>

                <!-- SEO -->
                <div class="card grid-margin">
                    <form method="POST" action="#">
                        <div class="card-body">
                            <h4 class="card-title">Gestion de la pièce</h4><br>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Image</label><br>
                                        <input type="file" class="file-upload-default cropInput" name="image" accept="image/*" data-shellid="" data-cropratio="1" data-choix='script/cropperPieceAdd.php' data-width = '600'>
                                        <div class="input-group col-xs-12">
                                            <input type="text" readonly class="form-control file-upload-warning" placeholder="Sélectionner un fichier" style="height: 42px;">
                                            <span class="input-group-append">
													<button class="file-upload-browse btn btn-gradient-warning" type="button">Choisir un fichier</button>
												</span>
                                        </div>
                                        <input type="hidden" name="ac_image" id="ac_image" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Libelle</label><br>
                                        <input type="text" name="pi_libelle" class="form-control" maxlength="255" placeholder="Nom de la pièce" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Type </label><br>
                                        <select class="form-control" onchange="typePiece()" id="pieceSelect" name="pi_id_type" required>
                                            <option value="" >-- Choisir le type de la pièce --</option>
                                            <?php
                                            foreach ($types as $value) {
                                                echo '<option value="'.$value['ty_id'].'">'.$value['ty_libelle'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label id="prix">Prix</label><br>
                                        <input type="number" name="pi_prix" class="form-control" maxlength="255" placeholder="Prix de la pièce" step="0.01" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Stock</label><br>
                                        <input type="number" name="pi_stock" class="form-control" maxlength="255" placeholder="Stock de la pièce" step="1" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Réference</label><br>
                                        <input type="text" name="pi_ref" class="form-control" maxlength="255" placeholder="Référence de la pièce" required>
                                    </div>
                                </div>
                                <div class="col-md-4" id="fournisseur">
                                    <div class="form-group">
                                        <label>Fournisseur</label><br>
                                        <input type="text" name="pi_fournisseur" class="form-control" maxlength="255" placeholder="Fournisseur de la pièce"  autocomplete="off">
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


    (function($) {
        'use strict';

        $('.file-upload-browse').on('click', function() {
            var file = $(this).parent().parent().parent().find('.file-upload-default');
            file.trigger('click');
        });
        $('.file-upload-default').on('change', function() {
            $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
        });

    })(jQuery);


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

                    $('#ac_image').val(imageName);


                    $.ajax(choixCrop, {
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,

                        success: function () {
                            //location.reload();
                        }

                    });

                });
            }
        });

    });
</script>

</body>
</html>