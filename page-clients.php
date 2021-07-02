<?php require 'script/page-clients.php'; ?>
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
                                <h4 class="card-title float-left">Gestion des clients</h4>
                                <a href="page-client-add" class="btn btn-gradient-warning float-right" style="margin-left: 10px;"><i class="fa fa-plus mr-2" aria-hidden="true"></i> AJOUTER</a>
                            </div>
                            <div class="col-12 mt-5">
                                <table class="table table-bordered table-hover  data-besoin">
                                    <thead>
                                    <tr>
                                        <th class="no-wrap">#</th>
                                        <th class="no-wrap">Nom</th>
                                        <th class="no-wrap">Adresse</th>
                                        <th class="no-wrap text-right"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($clients as $client) { ?>
                                        <tr>
                                            <td><?php echo $client['cl_id']; ?></td>
                                            <td><?php echo $client['cl_nom']; ?></td>
                                            <td><?php echo $client['cl_adresse']; ?></td>
                                            <td class="text-center">
                                                <a style="width: 130px;padding: 4px;" href="page-client-edit.php?id=<?php echo $client['cl_id']; ?>" class="btn btn-gradient-warning mb-2">Modifier</a><br>
                                                <button style="width: 130px;padding: 4px;" data-toggle="modal" data-target="#del-client" class="btn btn-gradient-warning" id="delclient<?php echo $client['cl_id']; ?>" onclick="delclient(<?php echo $client['cl_id']; ?>)">Supprimer</button>
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

<div class="modal fade" id="del-client" tabindex="-1" role="dialog">
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
                    <p class="lead">Confirmez-vous la suppression de cette client ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light float-left" data-dismiss="modal">NON</button>
                    <form action="#" method="POST">
                        <input type="hidden" name="cl_id" id="cl_id" required>
                        <button type="submit" class="btn btn-gradient-info" name="delete_client">OUI</button>
                    </form>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require 'base/script.php'; ?>
<script src="assets/vendors/tinymce/tinymce.min.js"></script>
<script src="assets/vendors/tinymce/themes/modern/theme.js"></script>

<!-- jqueryUI.js -->
<script src="assets/vendors/js/jqueryUI.js"></script>


<script type="text/javascript">

    document.getElementById("cliH").className += " active";

    function delclient(id) {
        document.getElementById('cl_id').value = id;
    }


    $('#data_acti').DataTable({
        "order": [[ 0, "desc" ]],
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