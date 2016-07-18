<div class="scan-result-box-body">
    <p class="login-box-msg">
        <?php echo LANG_VOTRE_REFERENCE; ?> <br/>
        <b class="table-line-neutral"> <?php  echo $this->_templatesParameters["order"][0]["EAN"] . ' / ' . $this->_templatesParameters["order"][0]["Fournisseur_Reference"] ?> </b> <br/>
        <b> <?php  echo $this->_templatesParameters["order"][0]["Marque"] . ' ' . $this->_templatesParameters["order"][0]["Profil"] ?> </b> <br/>
        <b> <?php  echo $this->_templatesParameters["order"][0]["Largeur"] . '/' . $this->_templatesParameters["order"][0]["Hauteur"] . ' R' . $this->_templatesParameters["order"][0]["Diametre"] . ' ' . $this->_templatesParameters["order"][0]["Indice_Charge"] . $this->_templatesParameters["order"][0]["Indice_Vitesse"]  ?></b>
    </p>
    <p class="login-box-msg medium">
        <?php echo LANG_NB_PNEUS_COLIS; ?>
    </p>
    <p class="login-box-msg big rehaussed">
        <?php echo $this->_templatesParameters["pneusDansColis"] ?>
    </p>
    <div class="row">
        <div class="col-xs-12">
            <a href="/scan/cancel/">
                <button class="btn btn-danger btn-block btn-flat" "> <?php echo LANG_ANNULER; ?></button>
            </a>
        </div><!-- /.col -->
    </div>
</div>
<?php if ($this->_templatesParameters["labelToStick"]): ?>
    <div class="scan-result-box-additional-message additional-info">
        <p class="login-box-msg medium">
            Mettez de coté et collez sur ce pneu l'étiquette <br/>
        </p>
        <p class="login-box-msg medium">
            <b><?php echo $this->_templatesParameters["labelToStick"] ?></b>
        </p>
    </div>
<?php endif; ?>
<?php if ($this->_templatesParameters["labelToGet"]): ?>
    <div class="scan-result-box-additional-message additional-info-2">
        <p class="login-box-msg medium">
            Colisez ce pneu avec le pneu <br/>
        </p>
        <p class="login-box-msg medium">
            <b><?php echo $this->_templatesParameters["labelToGet"] ?></b>
        </p>
    </div>
<?php endif; ?>
<?php if ($this->_templatesParameters["goodies"]): ?>
    <div class="scan-result-box-additional-message additional-info-3">
        <p class="login-box-msg medium">
            <b>Rajoutez un goodies dans le colis</b>
    </div>
<?php endif; ?>