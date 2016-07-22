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
        <div class="col-xs-4 col-md-offset-4">
          <div class="m1 customfont blu fs2">Interface Proxmox</div>
        </div>
    </div><!-- /.row -->
    <div class="row">
      <div class="col-xs-4 col-md-offset-4">
          <form class="form-vertical" role="form" method="POST" action="/controller/loginController.php">

            <div class="form-group has-feedback">
              <label for="ID VM" class="blu customfont">ID VM</label>
              <input type="number" name="ID" class="form-control" id="ID VM" placeholder="(ex : 145)">
              <span class="glyphicon glyphicon-th-large form-control-feedback blu"></span>
            </div>

            <div class="form-group has-feedback">
              <label for="nom_vm" class="blu customfont">Nom VM</label>
              <input type="text" name="nom_vm" class="form-control" id="nom_vm" placeholder="(ex : VM145)">
              <span class="glyphicon glyphicon-tag form-control-feedback blu"></span>
            </div>

            <div class="form-group has-feedback">
              <label for="password" class="blu customfont">Mot de passe</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="(ex : password)">
              <span class="glyphicon glyphicon-lock form-control-feedback blu"></span>
            </div>

            <div class="form-group has-feedback">
              <label for="password" class="blu customfont">Confirmer mot de passe</label>
              <input type="password" name="conf-password" class="form-control" id="conf-password" placeholder="(ex : password)">
              <span class="glyphicon glyphicon-lock form-control-feedback blu"></span>
            </div>

            <div class="form-group has-feedback">
              <label for="Espace disque" class="blu customfont">Espace Disque (MB)</label>
              <input type="number" min="512" name="disk_size" class="form-control" id="disk_size" value="512">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
              <div class="m3"><small>Recommandation => 4000 MB</small></div>
            </div>

  	        <button type="submit" class="btn btn-info customfont">Créer</button>
          </form>
      </div><!-- /.col-xs-4 col-md-offset-4  -->
    </div><!-- /.row -->
 </body>
</html>
