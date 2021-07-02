<?php

require 'bdd.php';

$idUser = $_POST['idUser'];


//Poste de travail
$dataPostes = $bdd->prepare('SELECT * FROM t_poste_travail pt JOIN r_qualification qu ON qu.qu_id_poste_travail = pt.pt_id WHERE qu.qu_id_ouvrier = ? ');
$dataPostes->execute([$idUser]);
$postes = $dataPostes->fetchAll();
$nbPostes = $dataPostes->RowCount();
$dataPostes->closeCursor();

$machines = [];
$nbMachines = 0;

foreach ($postes as $poste){
    //Machines
    $dataMachines = $bdd->prepare('SELECT * FROM t_machine ma JOIN r_machine_poste mp ON ma.ma_id = mp.ma_id WHERE mp.pt_id = ?');
    $dataMachines->execute([$poste['pt_id']]);
    $machinesTrouver = $dataMachines->fetchAll();
    if ($machines == []) {
        $machines = array_merge($machines,$machinesTrouver);
        $nbMachines += 1;
        $dataMachines->closeCursor();
    } else {
        $dejaMis = 0;
        foreach ($machinesTrouver as $machinesTr){
            foreach ($machines as $mach){
                if ($mach['ma_id'] == $machinesTr['ma_id']){
                    $dejaMis += 1;
                }
            }
            if ($dejaMis == 0){

                array_push($machines,$machinesTr);
                $nbMachines += 1;
                $dataMachines->closeCursor();

            }
        }
    }




}

if ($nbMachines > 0) {
    echo '<option value="">--Choisir une machine--</option>';
    foreach ($machines as $value) {

        echo '<option value="'.$value['ma_id'].'">'.$value['ma_libelle'].'</option>';
    }

} else {

    echo '<option value="">-- Aucune machine qualifié pour cet ouvrier --</option>';
}


