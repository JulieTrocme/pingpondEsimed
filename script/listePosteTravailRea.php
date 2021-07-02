<?php

require 'bdd.php';

$machine = $_POST['machine'];
$idOp = $_POST['idOp'];
$idUser = $_POST['idUser'];

if ($idUser != ''){
    //Qualification de l'ouvrier de la gamme
    $dataQualifs = $bdd->prepare('SELECT * FROM `t_ouvrier` JOIN r_qualification ON ou_id = qu_id_ouvrier JOIN t_poste_travail pt ON pt_id = qu_id_poste_travail JOIN r_machine_poste mp ON pt.pt_id = mp.pt_id JOIN t_machine ma ON mp.ma_id = ma.ma_id WHERE ou_id = ? AND ma.ma_id = ?');
    $dataQualifs->execute([$idUser,$machine]);
    $postes = $dataQualifs->fetchAll();
    $nbPostes = $dataQualifs->RowCount();
    $dataQualifs->closeCursor();

} else {
    //Qualification de l'ouvrier de la gamme
    $dataQualifs = $bdd->prepare('SELECT * FROM  t_poste_travail pt JOIN r_machine_poste mp ON pt.pt_id = mp.pt_id JOIN t_machine ma ON mp.ma_id = ma.ma_id WHERE ma.ma_id = ?');
    $dataQualifs->execute([$machine]);
    $postes = $dataQualifs->fetchAll();
    $nbPostes = $dataQualifs->RowCount();
    $dataQualifs->closeCursor();
}


if ($idOp != 0){
    $dataRealisation = $bdd->prepare('SELECT * FROM `t_realisation` WHERE `re_id` = ?');
    $dataRealisation->execute([$idOp]);
    $realisation = $dataRealisation->fetch();
    $dataRealisation->closeCursor();
}


if ($nbPostes > 0) {
    echo '<option value="">--Choisir un poste de travail--</option>';
    foreach ($postes as $value) {

        echo '<option value="'.$value['pt_id'].'"';
        if ($idOp != 0){
            if ($realisation['re_id_poste'] == $value['pt_id']){
                echo 'selected';
            }
        }
        echo '>'.$value['pt_libelle'].'</option>';
    }

} else {
    echo '<option value="">-- Aucun poste de travail qualifié pour cette machine --</option>';
}


