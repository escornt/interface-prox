<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <title>Interface proxmox</title>
      <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
      <link rel="stylesheet" href="test-style.css" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h1>Interface de création de conteneurs Proxmox</h1>
    </div>
&nbsp;
  <div class="row">
    <div class="col-xs-6">

        <form class="form-vertical" role="form">
          <div class="form-group">
            <label for="usr">Nom d'utilisateur :</label>
            <input type="usr" class="form-control" id="usr">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group">
            <label for="pwd">Mot de passe :</label>
            <input type="password" class="form-control" id="pwd">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="checkbox">
            <label><input type="checkbox"> Remember me</label>
          </div>
	         <button type="submit" class="btn btn-info">Submit</button>
         </form>
     </div>
   </div>
 </body>
</html>
