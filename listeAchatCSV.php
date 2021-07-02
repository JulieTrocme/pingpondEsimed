<?php
require 'script/session.php';

require 'script/bdd.php';


if(!empty($_POST) && isset($_POST['genere_excel_achat'])) {

    $mois = $_POST['mois'];

    if ($mois == ''){
        $mois = date("m")-1;

    }

    $dateDebut = '2021-' . $mois . '-01';

    $dateFin = date("Y-m-t", strtotime($dateDebut));

    //Commandes d'achat
    $dataCdeAchat = $bdd->prepare("SELECT * FROM `t_commande` WHERE co_id_type = 2 AND co_date_livraison_reelle IS NOT NULL AND co_date BETWEEN '$dateDebut' AND '$dateFin'");
    $dataCdeAchat->execute();
    $cdeAchats = $dataCdeAchat->fetchAll();
    $dataCdeAchat->closeCursor();

    $ligneAchats = [];


    //Toutes les Lignes de commande
    foreach ($cdeAchats as $cde){
        $dataLigneAchat = $bdd->prepare("SELECT pi_libelle,pi_ref,pi_fournisseur,lc_mtn, lc_qte, lc_mtn * lc_qte AS total FROM `t_ligne_commande` JOIN t_piece ON pi_id = lc_id_art WHERE `lc_id_commande` = ?");
        $dataLigneAchat->execute([$cde['co_id']]);
        $ligneAchats = array_merge($ligneAchats, $dataLigneAchat->fetchAll(\PDO::FETCH_NUM));
        $dataLigneAchat->closeCursor();
    }


    $filename = 'liste-facture-achat-mois-'.$mois.'.csv';

    array_to_csv_download($ligneAchats,$filename);


}


function array_to_csv_download($array, $filename,$delimiter=";") {
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w');
    // loop over the input array

    $colonne = array(array('libelle','Reference','fournisseur','prix unitaire','quantite', 'prix total'));

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