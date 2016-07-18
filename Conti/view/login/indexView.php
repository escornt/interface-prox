<div class="login-box">
    <div class="login-logo">
        <a href="#">
            <b>1001 Pneus</b><br/>
            Scanning Station
        </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo LANG_IDENTIFICATION; ?></p>
            <div class="form-group has-feedback">
                <input type="text" placeholder="User" name="userName" id="userName" class="form-control">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" placeholder="Password" name="password" id="password" class="form-control">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-primary btn-block btn-flat" id="submit-ident"><?php echo LANG_CONNEXION; ?></button>
                </div><!-- /.col -->
            </div>
    </div><!-- /.login-box-body -->
    <br/>
    <div class="login-box-body hidden" id="login-result">

    </div>
</div>

<script type="text/javascript">
var page = "login";
</script>
