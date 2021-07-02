<?php require 'script/page-devis.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="mdi mdi-account"></i></span>CLIENTS
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Gestion des Clients</li>
                        </ul>
                    </nav>
                </div>

                <!-- tableau client -->
                <div class="card grid-margin">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title float-left">Gestion des devis</h4>
                                <button type="button" class="btn btn-gradient-warning float-right" style="margin-left:10px;" data-toggle="modal" data-target="#modalDevis"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> Devis</button>
                            </div>
                            <div class="col-12 mt-5">
                                <table id="data_acti" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="no-wrap">#</th>
                                        <th class="no-wrap">N° Devis</th>
                                        <th class="no-wrap">Client</th>
                                        <th class="no-wrap">Date création</th>
                                        <th class="no-wrap">Date délais</th>
                                        <th class="no-wrap">Montant</th>
                                        <th class="no-wrap text-right"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($devis as $dev) { ?>
                                        <tr>
                                            <td><?php echo $dev['de_id']; ?></td>
                                            <td><?php echo str_pad($dev['de_id'], 6, "0", STR_PAD_LEFT); ?></td>
                                            <td><?php echo $dev['cl_nom']; ?></td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime(str_replace('-','/', $dev['de_date']))); ?></td>
                                            <td><?php if ($dev['de_date_delais']){ echo date('d/m/Y ', strtotime(str_replace('-','/', $dev['de_date_delais']))); }?></td>
                                            <td><?php echo $dev['de_mtn']; ?></td>

                                            <td class="text-center">
                                                <a style="width: 130px;padding: 4px;" href="page-devis-edit.php?id=<?php echo $dev['de_id'];?>" class="btn btn-gradient-warning mb-2"><?php if ($dev['de_date_delais']){ echo 'Consulter'; } else{ echo 'Modifier';}?></a><br>
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

    </div>
    <!-- page-body-wrapper ends -->
</div>

<!-- Modal devis -->
<div class="modal fade" id="modalDevis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter devis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-md-12">
                            <label>Client</label><br>

                            <select name="client" class="form-control" >
                                <option value="">--Choisir le client pour ce devis--</option>
                                <?php foreach ($clients as $value) {?>
                                    <option value="<?php echo $value['cl_id']; ?>"><?php echo $value['cl_nom']; ?></option>
                                <?php } ?>


                            </select>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                    <button type="submit" name="add" class="btn btn-success pull-right">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require 'base/script.php'; ?>
<script src="assets/vendors/tinymce/tinymce.min.js"></script>
<script src="assets/vendors/tinymce/themes/modern/theme.js"></script>

<!-- jqueryUI.js -->
<script src="assets/vendors/js/jqueryUI.js"></script>


<script type="text/javascript">

    document.getElementById("devH").className += " active";


    $('#data_acti').DataTable({
        "order": [[ 4, "desc" ]],
        "aLengthMenu": [
            [10, 20, 50, 100, 250],
            [10, 20, 50, 100, 250]
        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false,
            },
            {
                "targets": [ 4 ],
                "type": "date-euro"
            }
        ],
        "iDisplayLength": 10,
        "language": {
            "sProcessing":     "Traitement en cours...",
            "sSearch":         "Recherche",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo":           "Affichage des &eacute;l&eacute;ments _START_ &agrave; _END_ sur _TOTAL_",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            },
            "select": {
                "rows": {
                    _: "%d lignes séléctionnées",
                    0: "Aucune ligne séléctionnée",
                    1: "1 ligne séléctionnée"
                }
            }
        }
    });

</script>

</body>
</html>