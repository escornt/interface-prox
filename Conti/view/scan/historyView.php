
<div class="bot-historique">
    <div class="login-logo">
        <?php echo LANG_HISTORIQUE; ?>
    </div><!-- /.box-header -->
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped historique-content">
                <tbody>
                <?php foreach($this->_templatesParameters["history"] as $histo): ?>
                    <tr class="table-line-<?php echo strtolower($histo["type"]); ?>" data-histo-id="<?php echo $histo["id"] ?>">
                        <td class="col-md-2"><?php echo substr($histo["date"],0,16); ?></td>
                        <td class="col-md-8"><?php echo utf8_encode($histo["message"]); ?></td>
                        <?php  if ($histo["type"] =="INSERT"): ?>
                            <td class="col-md-2">
                                <button class='btn btn-block btn-primary btn-xs' type='button' id="printAgain"> <?php echo LANG_RE_IMPRESSION; ?></button>
                                <br/>
                                <button class='btn btn-block btn-xs' type='button' id="seeAdress"> <?php echo LANG_VOIR_ADRESSE; ?></button>
                            </td>
                        <?php else: ?>
                            <td class="col-md-2">
                                <button class='btn btn-block btn-default btn-xs disabled' type='button'> <?php echo LANG_RE_IMPRESSION; ?></button>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table><!-- /.table -->
        </div>
    </div><!-- /.box-body -->
</div>
