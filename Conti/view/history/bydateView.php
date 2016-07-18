<div class="col-xs-8 col-xs-offset-2 historique-table">
    <div class=historique-full">
        <div class="login-logo">
            <?php echo LANG_HISTORIQUE; ?> <?php echo $this->_templatesParameters["today"];?>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped history-content">
                    <tbody>
                    <?php foreach($this->_templatesParameters["history"] as $histo): ?>
                        <tr class="table-line" data-histo-id="<?php echo $histo["id"] ?>">
                            <td><?php echo substr($histo["date"],11,8); ?></td>
                            <td><?php echo $histo["ref1001pneus"]." - ".$histo["tyreNumber"]."<br/>
                            <b> Code Article </b>: ".$histo["Fournisseur_Reference"]." - <b>EAN</b> :".$histo["EAN"]."<br/>
                            <b> R&eacute;f&eacute;rence : </b>".$histo["tyreDef"]?></td>
                            <td><?php echo $histo["Adresse"]["societe"]." ". $histo["Adresse"]["civilite"]."<br/>".$histo["Adresse"]["adresse"]."<br/>".$histo["Adresse"]["ville"]; ?></td>
                            <td><button class='btn btn-block btn-primary btn-xs printAgain' type='button'><?php echo LANG_RE_IMPRESSION;?></button></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table><!-- /.table -->
            </div>
        </div><!-- /.box-body -->
    </div>
</div>
<button type="button" class="" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" id='openModal' style="display:none">Open Modal</button>

<script type="text/javascript">

var page = "history";
</script>