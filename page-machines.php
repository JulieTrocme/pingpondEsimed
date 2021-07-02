<?php require 'script/page-machines.php'; ?>
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
                        <span class="page-title-icon bg-gradient-warning text-white mr-2"><i class="fa fa-podcast"></i></span>Pages des machines
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Gestion des machines</li>
                        </ul>
                    </nav>
                </div>


                <div class="card grid-margin">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="card-title float-left">Gestion des machines</h4>
                                <button type="button" class="btn btn-gradient-warning float-right" style="margin-left:10px;" data-toggle="modal" data-target="#modalMachine"><i class="fa fa-plus" aria-hidden="true" style="padding-right:10px;"></i> AJOUTER</button>
                            </div>
                            <div class="col-12 mt-5">
                                <table class="table table-hover table-bordered data-besoin">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Libelle</th>
                                        <th>Poste de travail associé</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($machines as $value) { ?>
                                        <tr>
                                            <td><?php echo $value['ma_id'];?></td>

                                            <td><?php echo $value['ma_libelle'];?></td>

                                            <td>
                                                <?php
                                                $dataPostes = $bdd->prepare('SELECT * FROM r_machine_poste mp LEFT JOIN t_poste_travail pt ON pt.pt_id = mp.pt_id WHERE mp.ma_id = ?');
                                                $dataPostes->execute([$value['ma_id']]);
                                                $postesMachine = $dataPostes->fetchAll();
                                                $dataPostes->closeCursor();

                                                foreach ($postesMachine as $value){
                                                    echo $value['pt_libelle'].'<br><br>';
                                                }

                                                ?>

                                            </td>

                                            <td class="text-center">
                                                <a href="page-machine-edit.php?id=<?php echo $value['ma_id'];?>" class="btn btn-gradient-warning"  style="width: 130px;padding: 4px;">Modifier</a>
                                                <button style="width: 130px;padding: 4px;" data-toggle="modal" data-target="#del-Machine" class="btn btn-gradient-warning" id="delMachine<?php echo $value['ma_id']; ?>" onclick="delMachine(<?php echo $value['ma_id']; ?>)">Supprimer</button>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="del-Machine" tabindex="-1" role="dialog">
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
                                    <p class="lead">Confirmez-vous la suppression de cette machine ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light float-left" data-dismiss="modal">NON</button>
                                    <form action="#" method="POST">
                                        <input type="hidden" name="ma_id" id="ma_id" required>
                                        <button type="submit" class="btn btn-gradient-info" name="delete_machine">OUI</button>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="modalMachine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter une Machine</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="#" method="POST">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Libelle</label>
                                            <input type="text" name="libelle_machine" class="form-control" maxlength="200" placeholder="Libelle machine" required>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Les postes de travail pour cette machine</label><br>
                                            <?php foreach ($postes as $value) { ?>

                                                <input type="checkbox" id="<?php echo 'poste'.$value['pt_id'];?>" name="poste[]" value="<?php echo $value['pt_id'];?>">
                                                <label for="<?php echo 'poste'.$value['pt_id'];?>"> <?php echo $value['pt_libelle'];?></label><br>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                                    <button type="submit" name="add_machine" class="btn btn-success pull-right">Ajouter</button>
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
    document.getElementById("macH").className += " active";

    function delMachine(id) {
        document.getElementById('ma_id').value = id;
    }
</script>

</body>
</html>