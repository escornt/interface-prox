<div class="col-xs-6 col-xs-offset-3 historique-table">
    <div class=historique-full">
        <div class="login-logo">
            <?php echo LANG_HISTORIQUE; ?> <?php echo $this->_templatesParameters["today"];?>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">

            <?php foreach($this->_templatesParameters["history"] as $histo): ?>
                <span class="history-today-ref"><?php echo $histo["Marque"]." ". $histo["Profil"]." ".$histo["Largeur"]."/".$histo["Hauteur"]." R".$histo["Diametre"]." ".$histo["Indice_Charge"]." ".$histo["Indice_Vitesse"]." ";?></span>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped history-content">
                        <tbody>
                        <?php foreach($histo["packageList"] as $packageDetail): ?>
                            <tr class="table-line" data-histo-id="<?php echo $packageDetail["id"] ?>">
                                <td><?php echo $packageDetail["TyreNumber"]?> Pneus</td>
                                <td><?php echo $packageDetail["Adresse"]["civilite"]; ?></td>
                                <td><?php echo $packageDetail["Adresse"]["adresse"]; ?></td>
                                <td><?php echo $packageDetail["Adresse"]["ville"]; ?></td>
                                <td>
                                    <button class='btn btn-block btn-primary btn-xs printAgain' type='button'><?php echo LANG_RE_IMPRESSION; ?></button>
                                </td>
                        <?php endforeach; ?>
                    </tbody>
                </table><!-- /.table -->
            </div>
                </tr>
                <?php endforeach; ?>
        </div><!-- /.box-body -->
    </div>
</div>
<button type="button" class="" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" id='openModal' style="display:none">Open Modal</button>

<script type="text/javascript">

var page = "history";
</script>