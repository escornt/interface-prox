<?php
/**
 * ------------------------------------------------------------
 * Copyright (c)(c) 2015 1001pneus.
 * This software is the proprietary information of 1001pneus
 * All Right Reserved.
 * ------------------------------------------------------------
 *
 * SVN revision information:
 * @version 
 * @author  julien.pons
 * @date    13/10/2015 
 *
 */

?>

<span class="line1 adressDispay center "><?php echo ucfirst(strtolower($this->_templatesParameters["adressInfo"]['Livraison_Civilite'])); ?> <?php echo ucfirst(strtolower($this->_templatesParameters["adressInfo"]['Livraison_Nom'])); ?> <?php echo ucfirst(strtolower($this->_templatesParameters["adressInfo"]['Livraison_Prenom'])); ?></span>
<span class="line2 adressDispay center "><?php echo strtolower($this->_templatesParameters["adressInfo"]['Livraison_Adresse']); ?></span>
<span class="line3 adressDispay center "><?php echo $this->_templatesParameters["adressInfo"]['Livraison_CodePostal']; ?> <?php echo ucfirst(strtolower($this->_templatesParameters["adressInfo"]['Livraison_Ville'])); ?></span>