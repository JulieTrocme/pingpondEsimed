
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="">
            <div class="row">
                <div class="col-md-12" style="margin-top:10px;margin-left:10px;">
                    <img src="/assets/images/logo.png" alt="logo" class="mx-auto" style="margin-top: 20px;">
                </div>

            </div>
        </a>
        <a class="navbar-brand brand-logo-mini" href="">
            <img src="/assets/imagesg/logomini.png" alt="logo" class="mx-auto">
        </a>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-stretch">

        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item nav-profile">
                <!-- On affiche les messages flash -->
                <?php if(isset($_SESSION['flash'])): ?>
                    <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                        <div class="alert alert-<?php echo $type; ?> text-center mb-0" id="alert" style="min-width: 400px;">
                            <i class="fa fa-info-circle mr-1" aria-hidden="true"></i> <?= $message; ?>
                        </div>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['flash']); ?>
                <?php endif; ?>
            </li>

            <li class="nav-item nav-profile">
                <a class="nav-link" id="profil" href="#">
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black"><strong><?php echo $_SESSION['admin_login']['ou_login']?></strong></p>
                    </div>
                </a>
            </li>
            <li class="nav-item nav-logout d-none d-lg-block">
                <a class="nav-link" href="script/logout.php" title="Déconnexion">
                    <i class="mdi mdi-power" style="color:red;"></i>
                </a>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>

    </div>
</nav>