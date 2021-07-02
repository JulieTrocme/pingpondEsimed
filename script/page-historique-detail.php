<?php
require 'script/session.php';

if(isset($_GET['id']) && isset($_GET['date'])) {

    require 'script/bdd.php';

    $id = $_GET['id'];
    $date = $_GET['date'];

    //INFO DU CLIENT
    $dataRealisations = $bdd->prepare('SELECT * FROM t_realisation re JOIN r_gamme_realisation gre ON re.re_id = gre.re_id JOIN t_gamme ga ON ga.ga_id = gre.ga_id JOIN t_piece pi ON ga.ga_id_piece = pi.pi_id JOIN t_machine ma ON ma.ma_id=re.re_id_machine JOIN t_poste_travail pt ON pt.pt_id= re.re_id_poste LEFT JOIN t_ouvrier ou ON ou.ou_id = re.re_id_ouvrier WHERE gre.ga_id = ?AND re.re_date_effectue = ?');
    $dataRealisations->execute([$id,$date]);
    $realisations = $dataRealisations->fetchAll();
    $dataRealisations->closeCursor();

}


