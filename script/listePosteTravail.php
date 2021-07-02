<?php

require 'bdd.php';

$machine = $_POST['machine'];
$idOp = $_POST['idOp'];


//Poste de travail
$dataPostes = $bdd->prepare('SELECT * FROM t_poste_travail pt JOIN r_machine_poste rmp ON pt.pt_id = rmp.pt_id WHERE rmp.ma_id = ? ');
$dataPostes->execute([$machine]);
$postes = $dataPostes->fetchAll();
$nbPostes = $dataPostes->RowCount();
$dataPostes->closeCursor();



if ($idOp != 0){
    $dataOperation = $bdd->prepare('SELECT * FROM `t_operation` WHERE `op_id` = ?');
    $dataOperation->execute([$idOp]);
    $operation = $dataOperation->fetch();
    $dataOperation->closeCursor();
}


if ($nbPostes > 0) {
    echo '<option value="">--Choisir un poste de travail--</option>';
    foreach ($postes as $value) {

        echo '<option value="'.$value['pt_id'].'"';
        if ($idOp != 0){
            if ($operation['op_id_poste'] == $value['pt_id']){
                echo 'selected';
            }
        }
        echo '>'.$value['pt_libelle'].'</option>';
    }

} else {

    echo '<option value="">-- Aucun poste de travail qualifié pour cette machine --</option>';
}


