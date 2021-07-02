<?php
require 'script/session.php';

require 'script/bdd.php';


if(!empty($_POST) && isset($_POST['genere_excel_client'])) {

    $mois = $_POST['mois'];

    $mois = $_POST['mois'];

    if ($mois == ''){
        $mois = date("m")-1;

    }

    $dateDebut = '2021-' . $mois . '-01';

    $dateFin = date("Y-m-t", strtotime($dateDebut));

    //Commandes client
    $dataCdeCl = $bdd->prepare("SELECT cl_nom,co_date,co_mtn FROM `t_commande` JOIN t_client ON cl_id = co_id_client WHERE co_id_type = 1 AND co_statut = 1 AND co_date BETWEEN '$dateDebut' AND '$dateFin'");
    $dataCdeCl->execute();
    $cdeCls = $dataCdeCl->fetchAll(\PDO::FETCH_NUM);
    $dataCdeCl->closeCursor();

    $filename = 'liste-facture-client-mois-'.$mois.'.csv';


    array_to_csv_download($cdeCls,$filename);


}


function array_to_csv_download($array, $filename,$delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w');
    // loop over the input array

    $colonne = array(array('Client','Date de la commande','Montant total de la commande'));

    foreach ($colonne as $col) {
        // generate csv lines from the inner arrays
        fputcsv($f, $col,$delimiter);
    }

    foreach ($array as $line) {
        // generate csv lines from the inner arrays
        fputcsv($f, $line,$delimiter);
    }
    // reset the file pointer to the start of the file
    rewind($f);
    // tell the browser it's going to be a csv file
    header('Content-Type: application/csv; charset=UTF-8');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}
?>