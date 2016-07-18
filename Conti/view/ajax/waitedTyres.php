<select class="form-control" id="waited-tyres">
    <option value="null"><?php echo LANG_CHOISSISEZ_PNEU; ?> <br/></option>';
<?php
    foreach ($this->_templatesParameters["ListTyres"] as $tyre) {
        if (
            ($tyre["pneusColises"] + $_SESSION["currentProduct"]["nbPneus"]) < $tyre["pneusAColiser"] && $tyre["commandeProduitId"] == $_SESSION["currentProduct"]["order"]["commandeProduitId"] ||
            $tyre["commandeProduitId"] != $_SESSION["currentProduct"]["order"]["commandeProduitId"]
            ) {
                echo "<option value='" . $tyre["sku"] . "'>" . $tyre["Marque"] . " " . $tyre["Profil"] . " " . $tyre["Largeur"] . "/" . $tyre["Hauteur"] . " R" . $tyre["Diametre"] . " " . $tyre["Indice_Charge"] . $tyre["Indice_Vitesse"] . "</option>";
            }
    }
?>
</select>
<br/>
<button class="btn btn-default btn-block" id="validate-select"> <?php echo LANG_VALIDER; ?></button>