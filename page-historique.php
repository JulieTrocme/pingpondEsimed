<?php require 'script/page-historique.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-podcast"></i></span>Pages de l'historique des réalisations
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Historique des réalisations</li>
                        </ul>
                    </nav>
                </div>


                <div class="card grid-margin">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title float-left">Gestion de l'historiqque</h4>
                            </div>
                            <div class="col-12 mt-5">
                                <table class="table table-hover table-bordered data-besoin">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Pièce</th>
                                        <th>Gamme</th>
                                        <th>Responsable</th>
                                        <th>Date</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($gammes as $value) { ?>
                                        <tr>
                                            <td><?php echo $value['pi_id'];?></td>
                                            <td><?php echo $value['pi_libelle'];?></td>
                                            <td><?php echo $value['ga_libelle'];?></td>
                                            <td><?php echo $value['ou_prenom'].' '.$value['ou_nom'];?></td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime(str_replace('-','/', $value['re_date_effectue']))); ?></td>
                                            <td class="text-center">
                                                <a style="width: 130px;padding: 4px;" href="page-historique-detail.php?id=<?php echo $value['ga_id']?>&date=<?php echo $value['re_date_effectue']; ?>" class="btn btn-gradient-warning mr-2">Detail</a>
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

<?php require 'base/script.php'; ?>

<script type="text/javascript">
    document.getElementById("hisH").className += " active";


    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-euro-pre": function ( a ) {
            var x;

            if ( $.trim(a) !== '' ) {
                var frDatea = $.trim(a).split(' ');
                var frTimea = (undefined != frDatea[1]) ? frDatea[1].split(':') : [00,00,00];
                var frDatea2 = frDatea[0].split('/');
                x = (frDatea2[2] + frDatea2[1] + frDatea2[0] + frTimea[0] + frTimea[1] + ((undefined != frTimea[2]) ? frTimea[2] : 0)) * 1;
            }
            else {
                x = Infinity;
            }

            return x;
        },

        "date-euro-asc": function ( a, b ) {
            return a - b;
        },

        "date-euro-desc": function ( a, b ) {
            return b - a;
        }
    } );

</script>

</body>
</html>