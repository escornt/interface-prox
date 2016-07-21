<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Interface proxmox</title>
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <link rel="stylesheet" href= "<?php echo $_SERVER['HTTP_HOST']?>css/style.css" />
      <link href="https://fonts.googleapis.com/css?family=Changa" rel="stylesheet">
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
        <form class="form-vertical" role="form" method="POST" action="/controller/sub_handler.php">
          <div class="form-group has-feedback">
            <input type="usr" name="user" class="form-control" id="usr" placeholder="User">
            <span class="glyphicon glyphicon-user form-control-feedback blu"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="pswd" class="form-control" id="pwd" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback blu"></span>
          </div>
          <div class="checkbox">
            <label><input type="checkbox"><div class="customfont blu"> Remember me</div></label>
          </div>
	        <button type="submit" class="btn btn-info customfont">Submit</button>
          <?php if ($_SESSION['logstate'] == 1): ?>
            <div class="alert alert-danger m1"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Echec de l'authentification</div>
          <?php endif; ?>
        </form>
      </div><!-- login-box-body -->
    </div><!-- /.col-xs-4 col-md-offset-4  -->
  </div><!-- /.row -->
 </body>
</html>
