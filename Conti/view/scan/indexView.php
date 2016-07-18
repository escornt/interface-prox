<div class="col-xs-3 col-xs-offset-2">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">
                <b>Etape 2</b><br/>
                <?php echo LANG_SCAN_COLIS; ?>
            </a>
        </div><!-- /.login-logo -->
        <div class="login-box-body">
            <div class="login-box-msg"> <?php echo LANG_ACTIVATION_SCANETTE; ?>
                <div class="card-actions">
                    <input type="checkbox" hidden="hidden"  class="mswitch" id="enable-scan">
                    <label for="enable-scan" class="mswitch-helper js-switch-status-rule">
                    </label>
                </div>
            </div>
            <div class="form-group has-feedback">
                <form action="/scan/submit" id="scanform"></form>
                <input class="form-control hidden" type="text" id="scan-input">
                <div id="selectContainer">
                    <select class="form-control" id="waited-tyres">
                        <option value="null"> <?php echo LANG_CHOISSISEZ_PNEU; ?></option>
                        <?php foreach($this->_templatesParameters["Tyres"] as $tyre): ?>
                            <?php echo "<option value='".$tyre["sku"]."'>".$tyre["Marque"]." ".$tyre["Profil"]." ".$tyre["Largeur"]."/".$tyre["Hauteur"]." R".$tyre["Diametre"]." ".$tyre["Indice_Charge"].$tyre["Indice_Vitesse"]."</option>";?>
                        <?php endforeach; ?>
                    </select>
                    <br/>
                    <button class="btn btn-default btn-block" id="validate-select"> <?php echo LANG_VALIDER; ?></button>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <a href="/scan/pause/">
                        <button class="btn btn-primary btn-block btn-flat"> <?php echo LANG_MISE_EN_PAUSE; ?></button>
                    </a>
                </div>
                <div class="col-xs-6">
                    <a href="/scan/end/">
                        <button class="btn btn-primary btn-block btn-flat" "> <?php echo LANG_FIN_COLISAGE; ?></button>
                    </a>
                </div><!-- /.col -->
            </div>
        </div><!-- /.login-box-body -->
    </div>
    <div class="login-box" id="scan-result-box">

    </div><!-- /.login-box-body -->
</div>

<div class="col-xs-5 col-xs-offset-1" id="historique-table">
<?php require_once(BASEDIR."view/scan/historyView.php");?>
</div>
<button type="button" class="" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" id='openModal' style="display:none">Open Modal</button>
<button type="button" class="" data-toggle="modal" data-target="#myModalAdress" data-backdrop="static" data-keyboard="false" id='openModalAdress' style="display:none">Open Modal</button>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-large">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title center"> <?php echo LANG_ATTENTION;?></h3>
            </div>
            <div class="modal-body" id="messageInfo">
                <?php if($this->_templatesParameters["critical-message"]):?>
                    <?php echo $this->_templatesParameters["critical-message"];?>
                    <input type="hidden" id="displayModalPlease" value="ok">
                <?php endif;?>
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

<div class="modal fade" id="myModalAdress" role="dialog">
    <div class="modal-dialog modal-large">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title center"><?php echo LANG_ADRESSE;?></h3>
            </div>
            <div class="modal-body" id="adresseContent">

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
<script type="text/javascript">

var page = "scan";
</script>
