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
      <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="row">
        <div class="col-xs-4 col-md-offset-4">
          <div class="m1 customfont blu fs2">Interface Proxmox<br/>&nbsp Création de CT</div>
        </div>
    </div><!-- /.row -->
    <div class="row">
      <div class="col-xs-4 col-md-offset-4">
          <form class="form-vertical" role="form" method="POST" action="/controller/configController.php">
<!-- ID VM -->
            <div class="form-group has-feedback">
              <label for="ID VM" class="blu customfont" id="i1">ID CT <i class="fa fa-info-circle"></i></label>
              <div id="txt1" class="def-hidden"> <small>&nbsp Par défaut la dernière ID disponnible est sélectionnée.</small></div>
              <input type="number" name="ID" class="form-control" id="ID VM" value="<?php echo $_SESSION['lastID'] ?>">
              <span class="glyphicon glyphicon-th-large form-control-feedback blu"></span>
            </div>
<!-- Nom VM -->
            <div class="form-group has-feedback">
              <label for="nom_vm" class="blu customfont" id="i2">Nom CT <i class="fa fa-info-circle"></i></label>
              <div id="txt2" class="def-hidden"> <small>&nbsp Par défaut le lnom sera ct-user.</small></div>
              <input type="text" name="nom_vm" class="form-control" id="nom_vm" value="<?php echo "ct-".$_SESSION['user'] ?>">
              <span class="glyphicon glyphicon-tag form-control-feedback blu"></span>
            </div>
<!-- Description -->
            <div class="form-group has-feedback">
              <label for="description" class="blu customfont" id="i3">Description <i class="fa fa-info-circle"></i></label>
              <div id="txt3" class="def-hidden"> <small>&nbsp Conseil : entrez le propiétaire et l'utilité de la CT (ex : "user dev-mobile")</small></div>
              <input type="text" name="description" class="form-control" id="description" value="<?php echo "CT de ".$_SESSION['user'] ?>">
              <span class="glyphicon glyphicon-tags form-control-feedback blu"></span>
            </div>
<!-- Mot de passe -->
            <div class="form-group has-feedback">
              <label for="password" class="blu customfont" id="i4">Mot de passe <i class="fa fa-info-circle"></i></label>
              <div id="txt4" class="def-hidden"> <small>&nbsp Mot de passe de la CT, Minimum 5 caractères.</small></div>
              <input type="password" name="password" class="form-control" id="password" value="bbrother">
              <span class="glyphicon glyphicon-lock form-control-feedback blu"></span>
            </div>
<!-- Confimation mot de passe -->
            <div class="form-group has-feedback">
              <label for="password" class="blu customfont" id="i5">Confirmer mot de passe <i class="fa fa-info-circle"></i></label>
              <div id="txt5" class="def-hidden"> <small>&nbsp Entrez le mot de passe une nouvelle fois pour le confirmer.</small></div>
              <input type="password" name="conf-password" class="form-control" id="conf-password" value="bbrother">
              <span class="glyphicon glyphicon-lock form-control-feedback blu"></span>
            </div>
<!-- Espace Disque -->
            <div class="form-group has-feedback">
              <label for="Espace disque" class="blu customfont" id="i6">Espace Disque (GB) <i class="fa fa-info-circle"></i></label>
              <div id="txt6" class="def-hidden"> <small>&nbsp Recommandé -> 30 GB.</small></div>
              <input type="number" min="1" max="1000" name="disk_size" class="form-control" id="disk_size" value="30">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
            </div>
<!-- CPUs -->
            <div class="form-group has-feedback">
              <label for="CPU" class="blu customfont" id="i7">CPUs <i class="fa fa-info-circle"></i></label>
              <div id="txt7" class="def-hidden"> <small>&nbsp Recommandé -> 4.</small></div>
              <input type="number" min="1" name="CPU" class="form-control" id="CPU" value="4">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
            </div>
<!-- RAM -->
            <div class="form-group has-feedback">
              <label for="RAM" class="blu customfont" id="i8">RAM (MB) <i class="fa fa-info-circle"></i></label>
              <div id="txt8" class="def-hidden"> <small>&nbsp Recommandé -> 4000 MB.</small></div>
              <input type="number" min="512" max="16000" name="RAM" class="form-control" id="RAM" value="4000">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
            </div>
<!-- Swap -->
            <div class="form-group has-feedback">
              <label for="swap" class="blu customfont" id="i9">Swap (MB) <i class="fa fa-info-circle"></i></label>
              <div id="txt9" class="def-hidden"> <small>&nbsp Recommandé -> 1000 MB.</small></div>
              <input type="number" min="512" max="16000" name="swap" class="form-control" id="swap" value="1000">
              <span class="glyphicon glyphicon-hdd form-control-feedback blu"></span>
            </div>

            <div class="form-group has-feedback    ">
              <div class="blu customfont"><input type="radio" name="template" value="default" checked> Template par défaut. </div>
              <div class="blu customfont"><input type="radio" name="template" value="mobile"> Template pour dev mobile. </div>
            </div>

  <!--          <div class="form-group has-feedback">
              <label class="customfont blu"><input type="checkbox" id="cbox1" name="mount" checked> Monter le filer à la racine de la VM</label>
            </div>

            <div class="form-group has-feedback">
              <label class="customfont blu"><input type="checkbox" id="cbox2" name="update"> Mettre les sources à jour</label>
              <small><em>Nécessite le montage du filer</em></small>
            </div>
  -->

            <?php if ($_SESSION['ok-pass'] == 1): ?>
              <div class="alert alert-danger m2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erreur,</strong><br/>Renseignez et confirmez un mot de passe valide.</div>
            <?php endif; ?>

            <?php if ($_SESSION['ok-empty'] == 1): ?>
              <div class="alert alert-danger m2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erreur,</strong><br/>Pour valider le formulaire, aucun champ me doit être laissé vide.</div>
            <?php endif; ?>

            <?php if ($_SESSION['ok-log'] == 1): ?>
              <div class="alert alert-danger m2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erreur,</strong><br/>Le serveur proxmox est innaccessible, réessayez plus tard.</div>
            <?php endif; ?>
            <?php if ($_SESSION['ok-exist'] == 1): ?>
              <div class="alert alert-danger m2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erreur,</strong><br/>Cette ID de VM est déjà utilisée.</div>
            <?php endif; ?>
            <?php if ($_SESSION['ok-creat'] == 1): ?>
              <div class="alert alert-danger m2"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Erreur,</strong><br/>La création de la VM à échouée.</div>
            <?php endif; ?>
            <div class="alert alert-success m2 def-hidden" id="sub-ok">
              <strong>Création de la VM</strong><br/>La création de la machine peut prendre quelques minutes.      <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
            </div>
  	        <button type="submit" class="btn btn-info customfont" id="sub">Créer</button>
          </form>
      </div><!-- /.col-xs-4 col-md-offset-4 -->
    </div><!-- /.row -->
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
    <script src="/js/hide-show.js"></script>
    <script src="/js/display_onclick.js"></script>
 </body>
</html>
