<?php require 'script/login.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<?php require 'base/head.php'; ?>

<body>

  <div class="container-scroller">

    <div class="container-fluid page-body-wrapper full-page-wrapper">

      <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg" style="background: #ffffff;">

        <div class="row flex-grow">

          <div class="col-lg-6 d-flex align-items-center justify-content-center">

              <div class="auth-form-transparent text-left p-3">

                  <div class="brand-logo text-center">
                    <div class="row">

                      <div class="col-md-12">
                        <img src="/assets/images/logo.png" alt="logo" class="mx-auto" style="width: 50%;">
                      </div>
                    </div>
                  </div>

                  <!-- On affiche les messages flash -->
                  <?php if(isset($_SESSION['flash'])): ?>
                    <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                      <div class="alert alert-<?php echo $type; ?> text-center" id="alert" style="margin-bottom: 0px;">
                        <?= $message; ?>
                      </div>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['flash']); ?>
                  <?php endif; ?>

                  <form class="pt-3" action="#" method="POST">

                      <div class="form-group">
                        <label for="InputEmail">Identifiant</label>
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <span class="input-group-text bg-transparent border-right-0">
                                    <i class="mdi mdi-account-outline text-warning"></i>
                                </span>
                            </div>
                            <input type="text" name="username" class="form-control form-control-lg border-left-0" id="InputEmail" required placeholder="Identifiant">
                        </div>
                      </div> 

                      <div class="form-group">
                          <label for="InputPassword">Mot de passe</label>
                          <div class="input-group">
                              <div class="input-group-prepend bg-transparent">
                                  <span class="input-group-text bg-transparent border-right-0">
                                      <i class="mdi mdi-lock-outline text-warning"></i>
                                  </span>
                              </div>
                              <input type="password" name="password" class="form-control form-control-lg border-left-0" id="InputPassword" required placeholder="Mot de passe">
                          </div>
                      </div>

                      <div class="my-3">
                          <button type="submit" name="login" class="btn btn-block btn-gradient-warning btn-lg font-weight-medium auth-form-btn" href="../../index.html">CONNEXION</button>
                      </div>

                  </form>
              </div>
          </div>

          <div class="col-lg-6 login-half-bg d-flex flex-row"></div>

        </div>

      </div>

    </div>

  </div>

  <?php require 'base/script.php'; ?>

</body>
</html>