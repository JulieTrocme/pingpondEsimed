<?php require 'script/page-postes.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-podcast"></i></span>Pages des postes
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Gestion des postes</li>
                        </ul>
                    </nav>
                </div>


                <div class="card grid-margin">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title float-left">Gestion des postes</h4>
                                <button type="button" class="btn btn-gradient-warning float-right" style="margin-left:10px;" data-toggle="modal" data-target="#modalPoste"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> AJOUTER</button>
                            </div>
                            <div class="col-12 mt-5">
                                <table class="table table-hover table-bordered data-besoin">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Libelle</th>
                                        <th>Machine associé</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($postes as $value) { ?>
                                        <tr>
                                            <td><?php echo $value['pt_id'];?></td>

                                            <td><?php echo $value['pt_libelle'];?></td>

                                            <td>
                                                <?php
                                                $dataMachines = $bdd->prepare('SELECT * FROM r_machine_poste mp LEFT JOIN t_machine ma ON ma.ma_id = mp.ma_id WHERE mp.pt_id = ?');
                                                $dataMachines->execute([$value['pt_id']]);
                                                $machinesPoste = $dataMachines->fetchAll();
                                                $dataMachines->closeCursor();

                                                foreach ($machinesPoste as $value){
                                                    echo $value['ma_libelle'].'<br><br>';
                                                }

                                                ?>

                                            </td>

                                            <td class="text-center">
                                                <a href="page-poste-edit.php?id=<?php echo $value['pt_id'];?>" class="btn btn-gradient-warning"  style="width: 130px;padding: 4px;">Modifier</a>
                                                <button style="width: 130px;padding: 4px;" data-toggle="modal" data-target="#del-poste" class="btn btn-gradient-warning" id="delPoste<?php echo $value['pt_id']; ?>" onclick="delPoste(<?php echo $value['pt_id']; ?>)">Supprimer</button>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="del-poste" tabindex="-1" role="dialog">
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
                                    <p class="lead">Confirmez-vous la suppression de ce poste de travail ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light float-left" data-dismiss="modal">NON</button>
                                    <form action="#" method="POST">
                                        <input type="hidden" name="pt_id" id="pt_id" required>
                                        <button type="submit" class="btn btn-gradient-info" name="delete_poste">OUI</button>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="modalPoste" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter un poste de travail</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="#" method="POST">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Libelle</label>
                                            <input type="text" name="libelle_poste" class="form-control" maxlength="200" placeholder="Libelle poste de travail" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Les machines pour ce poste de travail</label><br>
                                            <?php foreach ($machines as $value) { ?>

                                                <input type="checkbox" id="<?php echo 'machine'.$value['ma_id'];?>" name="machine[]" value="<?php echo $value['ma_id'];?>">
                                                <label for="<?php echo 'machine'.$value['ma_id'];?>"> <?php echo $value['ma_libelle'];?></label><br>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                                    <button type="submit" name="add_poste" class="btn btn-success pull-right">Ajouter</button>
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

<script type="text/javascript">
    document.getElementById("posH").className += " active";

    function delPoste(id) {
        document.getElementById('pt_id').value = id;
    }
</script>

</body>
</html>