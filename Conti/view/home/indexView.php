<div class="login-box">
    <div class="login-logo">
        <a href="#">
            <b><?php echo LANG_ETAPE; ?> 1</b><br/>
            <?php echo LANG_DEMARER_COLISAGE; ?>
        </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo LANG_VALIDER_CLIC; ?></p>
        <div class="row">
            <div class="col-xs-6 ">
                <a href="/home/start/">
                    <button class="btn btn-primary btn-block btn-flat" ><?php echo LANG_VALIDER; ?></button>
                </a>
            </div>
            <div class="col-xs-6">
                <a href="/home/logout/">
                    <button class="btn btn-danger btn-block btn-flat" "><?php echo LANG_ANNULER; ?></button>
                 </a>
            </div><!-- /.col -->
        </div>
    </div><!-- /.login-box-body -->
    <br/>
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo LANG_DAILY_HISTORIQUE; ?></p>
        <div class="row">
            <div class="col-xs-6">
                <a href="/history/">
                    <button class="btn btn-primary btn-block btn-flat" ><?php echo LANG_HISTORIQUE ?></button>
                </a>
            </div>
            <div class="col-xs-6">
                <a href="/history/bydate/">
                    <button class="btn btn-primary btn-block btn-flat" ><?php echo LANG_DATE_HISTORIQUE ?></button>
                </a>
            </div>

    </div><!-- /.login-box-body -->
</div>

<script type="text/javascript">
var page = "home";
</script>
