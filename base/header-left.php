<?php
    $dataRolesUser = $bdd->prepare('SELECT * FROM  r_role_ouvrier WHERE ou_id = ?');
    $dataRolesUser->execute([$_SESSION['admin_login']['ou_id']]);
    $rolesUser = $dataRolesUser->fetchAll();
    $dataRolesUser->closeCursor();
?>

<!-- Menu -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <br><br>

      <?php foreach ($rolesUser as $value) {
          if ($value['ro_id'] == 1){
              echo '
                 <li class="nav-item" id="useH">
                  <a class="nav-link" href="page-personnel">
                    <span class="menu-title">Personnels</span>
                    <i class="fa fa-user menu-icon" aria-hidden="true"></i>
                  </a>
                </li>';
          }
          if ($value['ro_id'] == 2){
              echo '
                <li class="nav-item" id="besH">
                  <a class="nav-link" href="page-pieces">
                      <span class="menu-title">Atelier</span>
                      <i class="fa fa-podcast menu-icon"></i>
                  </a>
                </li>
                <li class="nav-item" id="macH">
                  <a class="nav-link" href="page-machines">
                      <span class="menu-title">Machine</span>
                      <i class="fa fa-podcast menu-icon"></i>
                  </a>
                </li>
                <li class="nav-item" id="posH">
                  <a class="nav-link" href="page-postes">
                      <span class="menu-title">Poste de travail</span>
                      <i class="fa fa-podcast menu-icon"></i>
                  </a>
                </li>
                 <li class="nav-item" id="hisH">
                  <a class="nav-link" href="page-historique">
                      <span class="menu-title">Historique</span>
                      <i class="fa fa-podcast menu-icon"></i>
                  </a>
                </li>';
          }

          if ($value['ro_id'] == 3){
              echo '
                <li class="nav-item" id="comH">
                  <a class="nav-link" href="page-commande">
                      <span class="menu-title">Commandes</span>
                      <i class="fa fa-archive menu-icon" aria-hidden="true"></i>
                  </a>
                </li>
                <li class="nav-item" id="devH">
                  <a class="nav-link" href="page-devis">
                      <span class="menu-title">Devis</span>
                      <i class="fa fa-archive menu-icon" aria-hidden="true"></i>
                  </a>
                </li>
                <li class="nav-item" id="cliH">
                  <a class="nav-link" href="page-clients">
                      <span class="menu-title">Clients</span>
                      <i class="fa fa-archive menu-icon" aria-hidden="true"></i>
                  </a>
                </li>';
          }
          ?>




      <?php } ?>


    <br><br>
    <li class="nav-item">
      <a class="nav-link" href="script/logout">
        <span class="menu-title">Déconnexion</span>
        <i class="mdi mdi-power menu-icon"></i>
      </a>
    </li>

  </ul>
</nav>
