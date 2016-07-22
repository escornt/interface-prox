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
<!-- ID VM -->
            <div class="form-group has-feedback">
              <label for="ID VM" class="blu customfont">ID VM</label>
              <input type="number" name="ID" class="form-control" id="ID VM" placeholder="(ex : 145)">
              <span class="glyphicon glyphicon-th-large form-control-feedback blu"></span>
            </div>
<!-- Nom VM -->
            <div class="form-group has-feedback">
              <label for="nom_vm" class="blu customfont">Nom VM</label>
              <input type="text" name="nom_vm" class="form-control" id="nom_vm" placeholder="(ex : VM145)">
              <span class="glyphicon glyphicon-tag form-control-feedback blu"></span>
            </div>
<!-- Mot de passe -->
            <div class="form-group has-feedback">
              <label for="password" class="blu customfont">Mot de passe</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="(ex : password)">
              <span class="glyphicon glyphicon-lock form-control-feedback blu"></span>
            </div>
<!-- Confimation mot de passe -->
            <div class="form-group has-feedback">
              <label for="password" class="blu customfont">Confirmer mot de passe</label>
              <input type="password" name="conf-password" class="form-control" id="conf-password" placeholder="(ex : password)">
              <span class="glyphicon glyphicon-lock form-control-feedback blu"></span>
            </div>
<!-- Espace Disque -->
            <div class="form-group has-feedback">
              <label for="Espace disque" class="blu customfont">Espace Disque (GB)</label>
              <input type="number" min="1" max="1000" name="disk_size" class="form-control" id="disk_size" value="15">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
              <div class="m3"><em><small>Recommandation mini --> 15 GB</small></em></div>
            </div>
<!-- CPUs -->
            <div class="form-group has-feedback">
              <label for="CPU" class="blu customfont">CPUs</label>
              <input type="number" min="1" name="CPU" class="form-control" id="CPU" value="1">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
              <div class="m3"><em><small>Recommandation mini --> 1</small></em></div>
            </div>
<!-- RAM -->
            <div class="form-group has-feedback">
              <label for="RAM" class="blu customfont">RAM (MB)</label>
              <input type="number" min="512" max="16000" name="RAM" class="form-control" id="RAM" value="4000">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
              <div class="m3"><em><small>Recommandation mini --> 4000 MB </small></em></div>
            </div>
<!-- Swap -->
            <div class="form-group has-feedback">
              <label for="swap" class="blu customfont">Swap (MB)</label>
              <input type="number" min="512" max="16000" name="swap" class="form-control" id="swap" value="4000">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
              <div class="m3"><em><small>Recommandation mini --> 4000 MB </small></em></div>
            </div>

  	        <button type="submit" class="btn btn-info customfont">Créer</button>
          </form>
      </div><!-- /.col-xs-4 col-md-offset-4  -->
    </div><!-- /.row -->
 </body>
</html>
