
<div class="login-box">
    <div class="login-logo">
        <a href="#">
            <b><?php echo LANG_ETAPE; ?> 4</b><br/>
            <?php echo LANG_FIN_SCAN; ?>
        </a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg medium">
            <?php echo LANG_VOUS_AVEZ_PREPARE; ?>
            <b><?php echo $_SESSION["PackageCount"];?><?php echo LANG_COLIS; ?></b><br/>
        </p>
        <div class="row">
            <div class="col-xs-12">
                <a href="/">
                    <button class="btn btn-primary btn-block btn-flat" ><?php echo LANG_FIN; ?></button>
                </a>
            </div>
        </div>
    </div><!-- /.login-box-body -->
</div>
<?php if($this->_templatesParameters["critical-message"]):?>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-large">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title center"><?php echo LANG_ATTENTION; ?></h3>
            </div>
            <div class="modal-body" id="messageInfo">
                <?php echo $this->_templatesParameters["critical-message"];?>
            </div>
            <div class="modal-footer">
                <div class="col-xs-4 col-xs-offset-4
                            col-sm-4 col-sm-offset-4
                            col-md-4 col-md-offset-4
                            col-lg-4 col-lg-offset-4
                            center">
                    <a class="btn btn-default btn-l" href="#" data-dismiss="modal" id="validateLabel">
                        Ok
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
<button type="button" class="" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" id='openModal' style="display:none">Open Modal</button>
<?php endif;?>
<script type="text/javascript">
var page = "end";
</script>
