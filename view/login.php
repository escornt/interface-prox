<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Portail Interface Proxmox</title>
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <link rel="stylesheet" href="/css/style.css" />
      <link rel="shortcut icon" href="/css/favicon.ico" />
      <link href="https://fonts.googleapis.com/css?family=Changa" rel="stylesheet" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="row">
        <div class="col-xs-4 col-md-offset-4">
          <div class="m1 customfont blu fs2">Interface Proxmox</div>
        </div>
    </div><!-- /.row -->
  <div class="row">
    <div class="col-xs-4 col-md-offset-4">
      <div class="login-box-body">
        <form class="form-vertical" role="form" method="POST" action="/controller/loginController.php">
          <div class="form-group has-feedback">
            <input type="usr" name="user" class="form-control" id="usr" placeholder="User">
            <span class="glyphicon glyphicon-user form-control-feedback blu"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="pswd" class="form-control" id="pwd" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback blu"></span>
          </div>
	        <button type="submit" class="btn btn-info customfont">Submit</button>
          <?php if ($_SESSION['substate'] == 1): ?>
            <div class="alert alert-danger m2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erreur</strong><br/>Echec de l'authentification, mauvais identifiants.</div>
          <?php endif; ?>
          <?php if ($_SESSION['droits'] == 1): ?>
            <div class="alert alert-danger m2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erreur</strong><br/>Vous ne disposez pas des droits pour accéder à cette page.</div>
          <?php endif; ?>
          <?php if ($_SESSION['ok-log'] == 1): ?>
            <div class="alert alert-danger m2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erreur</strong><br/>Echec de la connexion au serveur Proxmox.</div>
          <?php endif; ?>
        </form>
      </div><!-- login-box-body -->
    </div><!-- /.col-xs-4 col-md-offset-4  -->
  </div><!-- /.row -->
 </body>
</html>
