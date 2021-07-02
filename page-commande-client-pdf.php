<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 'on');

//require __DIR__.'/vendor/autoload.php';
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require $root.'/assets/vendors/autoload.php';
require $root.'/script/bdd.php';

use Spipu\Html2Pdf\Html2Pdf;

if(isset($_GET['orderID']) && is_numeric($_GET['orderID'])) {

    $cdeID = $_GET['orderID'];

    //GET commande entière
    $dataCart = $bdd->prepare('SELECT * FROM t_commande co LEFT JOIN t_client cl ON co.co_id_client = cl.cl_id WHERE co_id = ?');
    $dataCart->execute([$cdeID]);

    //On verifie si le clien correspond

    if($dataCart->rowCount() > 0) {

        $commande = $dataCart->fetch();

        $cdeNum = str_pad($commande['co_id'], 6, "0", STR_PAD_LEFT);

        //GET Ligne cde
        $dataLigne = $bdd->prepare('SELECT * FROM t_ligne_commande lc LEFT JOIN t_piece pi ON lc.lc_id_art = pi.pi_id WHERE lc_id_commande = ?');
        $dataLigne->execute([$cdeID]);
        $lignesCount = $dataLigne->rowCount();
        $lignes = $dataLigne->fetchAll();
        $dataLigne->closeCursor();



        //GET Adresse de livraison
        $dataAdresseLivraison = $bdd->prepare('SELECT * FROM t_client WHERE cl_id = ?');
        $dataAdresseLivraison->execute([$commande['co_id_client']]);
        $adresseLivraison = $dataAdresseLivraison->fetch();
        $dataAdresseLivraison->closeCursor();



        //On prépare le contenu du pdf
        if($lignesCount > 0) {

            //Site
            $user = array(
                "id" => 1,
                "siret" => "419 100 540",
                "firstname" => "Pingpong ",
                "lastname" => 'Esimed',
                "email" => "contact@pingpong-esimed.fr",
                "portable" => "06 77 59 03 20",
                "address" => "22 rue john Maynard Keyne,\n13013 Marseille\nFrance"
            );


                //Client Livraison
                $clientLiv = array(
                    "id" => 1,
                    "firstname" => $adresseLivraison['cl_nom'],
                    //"lastname" => $adresseLivraison['ad_surname'],
                    "address" => $adresseLivraison['cl_adresse']/*.'<br>'.$adresseLivraison['cl_cp'].' '.$adresseLivraison['cl_ville']*/,
                    "infos" => ""
                );



            $i = 1; $description = "";
            foreach ($lignes as $value) {

                $tasks[] = array(
                    "id" => $i,
                    "description" => '<h5 style="margin-bottom: 0">'.$value['pi_libelle'].'</h5>'.'<small>Ref : '.$value['pi_ref'].'</small>',
                    "price" => $value['lc_mtn'],
                    "quantity" => $value['lc_qte'],
                    "total" => number_format(round($value['lc_mtn'] * $value['lc_qte'], 2), 2),
                    "project_id" => 1
                );

                $i++;
            }

            $total = 0;  $total_ht = 0; $ecoTaxe = 0;

            //CSS
            $content = '
        <style type="text/css">
          table { 
              width: 100%; 
              color: #717375; 
              font-family: helvetica; 
              line-height: 5mm; 
              border-collapse: collapse; 
          }
          h2 { margin: 0; padding: 0; }
          p { margin: 5px; }
       
          .border th { 
              border: 1px solid #000;  
              color: white; 
              background: #000; 
              padding: 5px; 
              font-weight: normal; 
              font-size: 14px; 
              text-align: center; 
              }
          .border td { 
              border: 1px solid #CFD1D2; 
              padding: 5px 10px; 
              text-align: center; 
          }
          .no-border { 
              border-right: 1px solid #CFD1D2; 
              border-left: none; 
              border-top: none; 
              border-bottom: none;
          }
          .space { padding-top: 250px; }
          .li_design { font-size:10px;text-align:left; }
          .10p { width: 10%; } .15p { width: 15%; } 
          .25p { width: 25%; } .50p { width: 50%; } 
          .60p { width: 60%; } .75p { width: 75%; }
          .40p { width: 40%; } .70p { width: 70%; }
          .30p { width: 30%; } .33p { width: 33%; }
        </style>';

            $content .= '
        <page backtop="10mm" backleft="10mm" backright="10mm" backbottom="10mm" footer="page;">
       
          <page_footer>
              <hr />
              <p></p>
          </page_footer>
       
          <table style="vertical-align: top;">
              <tr>
                  <td class="50p"></td>
                  <td class="25p">Livraison :</td>
              </tr>
          </table>

          <table style="vertical-align: top;margin-top: 15px;">
              <tr>
                  <td class="50p">
                      <strong>'.$user["firstname"].$user["lastname"].'</strong><br />
                      '.nl2br($user["address"]).'<br />
                      SIRET: '.$user["siret"].'<br />
                      '.$user["email"].'<br />
                      '.$user["portable"].'<br />
                  </td>
                  <td class="50p">
                      <strong>'.$clientLiv["firstname"].'</strong><br />
                      '.nl2br($clientLiv["address"]).'<br />
                  </td>
              </tr>
          </table>
       
          <table style="margin-top: 50px;">
              <tr>
                  <td class="50p"><h2>COMMANDE N° '.$cdeNum.'</h2></td>
                  <td class="50p" style="text-align: right;">Date commande : '.date('d/m/Y H:i:s', strtotime(str_replace('-','/', $commande['co_date']))).'</td>
              </tr>
          </table>
       
          <table style="margin-top: 30px;" class="border">
              <thead>
                  <tr>
                      <th class="60p">Description</th>
                      <th class="10p">Quantité</th>
                      <th class="15p">Prix Unitaire</th>
                      <th class="15p">Montant</th>
                  </tr>
              </thead>
              <tbody>';

            foreach ($tasks as $task) {

                $total += $task["total"];
                $total_ht += round($task["total"] , 2);


                $content .= '<tr>';
                $content .= '    <td class="li_design">'.wordwrap($task["description"], 100, "<br />\n").'</td>';
                $content .= '    <td>'.$task["quantity"].'</td>';
                $content .= '    <td style="text-align:right;">'.$task["price"].' €</td>';
                $content .= '    <td style="text-align:right;">'.$task["total"].' €</td>';
                $content .= '</tr>';
            }
           // $TVA = round((($total_ht*1.2) - $total_ht ),2);
            //$totalTTC = $total + $ecoTaxe + $TVA;

            $content .= '
                  <tr>
                      <td class="space"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                  </tr>
       
                 <tr>
                      <td colspan="2" class="no-border"></td>
                      <td style="text-align: center;" rowspan="4"><strong>Total :</strong></td>
                      <td style="text-align:right;">TTC : '.$total.' €</td>
                  </tr>
                 
                  
              </tbody>
          </table>

          <table style="vertical-align: top;margin-top: 50px;">
              <tr>
                  <td class="50p"></td>
                  <td class="50p"></td>
              </tr>
          </table>

        </page>';

            //Préparation du fichierpdf
            $html2pdf = new Html2Pdf("p","A4","fr");
            $html2pdf->pdf->SetAuthor('Pingpong Esimed');
            $html2pdf->pdf->SetTitle('COMMANDE '.$cdeNum);
            $html2pdf->writeHTML($content);
            $html2pdf->output('Commande-Pingpong-Esimed-'.$cdeNum.'.pdf');
        }

    }
    $dataCart->closeCursor();

}



