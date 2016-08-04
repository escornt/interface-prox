<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Interface Proxmox</title>
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <link rel="stylesheet" href="/css/style.css" />
      <link rel="shortcut icon" href="/css/favicon.ico" />
      <link href="https://fonts.googleapis.com/css?family=Changa" rel="stylesheet" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="row">
        <div class="col-xs-5 col-md-offset-3">
          <div class="m1 customfont blu fs2">La CT <?php echo $_SESSION['ID']; ?> a été créée avec succès</div>
          <p class="customfont blu m1">
            IP : <?php echo $_SESSION['ip'] ?><br/>
            <br/>
            Pour une configuration plus personnalisée
            <a href="http://wiki.1001pneus.fr/doku.php?id=it:it:interface_vm&#configuration_avancee">Cliquez ici.</a>
          </p>
        </div>
    </div><!-- /.row -->
  </body>
