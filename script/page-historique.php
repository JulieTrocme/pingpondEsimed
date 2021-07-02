<?php
    require 'script/session.php';

    require 'script/bdd.php';

//INFO DU CLIENT
$dataGammes = $bdd->query('SELECT * FROM `t_realisation` re JOIN r_gamme_realisation gre ON gre.re_id = re.re_id JOIN t_gamme ga ON ga.ga_id = gre.ga_id JOIN t_piece pi ON ga.ga_id_piece = pi.pi_id JOIN t_ouvrier ou ON ou.ou_id = ga.ga_id_responsable GROUP BY `re_date_effectue`');
$dataGammes->execute();
$gammes = $dataGammes->fetchAll();
$dataGammes->closeCursor();


