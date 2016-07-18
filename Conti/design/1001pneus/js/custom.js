/**
 * Created by julien.pons on 07/07/2015.
 */
switch(page){
    case "scan":
        jQuery(document).ready(function(){
           /*
            * Affichage de la modal quand on a cliqué sur pause et qu'un problème est survenu lors de l'envoi
            * d'étiquette au ftp
            */
            if(jQuery('#displayModalPlease').val() =="ok"){
                jQuery('#openModal').trigger("click");
            }

           /*
            * Init du select amélioré
            */
            jQuery('#waited-tyres').select2({width: 'resolve'});

           /*
            * Gestion du bouton Toggle et de l'affichage du select ou de l'input par défault
            */
            if(jQuery('#enable-scan').is(':checked') == true) {
                jQuery('#scan-input').prop('disabled', false);
                jQuery('#scan-input').removeClass("hidden");
                jQuery('#scan-input').focus();
                jQuery('#waited-tyres').prop('disabled', true);
                jQuery('#waited-tyres').parent().hide();

            }else {
                jQuery('#scan-input').prop('disabled', true);
                jQuery('#scan-input').addClass("hidden");
                jQuery('#waited-tyres').prop('disabled', false);
                jQuery('#waited-tyres').parent().show();
            }

           /*
            * Clic sur le bouton Toggle et de l'affichage du select ou de l'input
            */
            jQuery('#enable-scan').change(function(){
                if(jQuery('#enable-scan').is(':checked') == true){
                    jQuery('#scan-input').prop('disabled', false);
                    jQuery('#scan-input').removeClass("hidden");
                    jQuery('#scan-input').focus();
                    jQuery('#waited-tyres').parent().hide();
                }else{
                    jQuery('#scan-input').prop('disabled', true);
                    jQuery('#scan-input').addClass("hidden");
                    jQuery('#waited-tyres').prop('disabled', false);
                    jQuery('#waited-tyres').parent().show();
                }
            });

           /*
            * On cache la fenetre qui va contenir le résultat du scan par défaut
            */
            jQuery(".scan-result-box").hide();

           /*
            * Gestion du clic sur le bouton valider après selection d'une référence dans une select boc
            */
            jQuery('#selectContainer').on('click','#validate-select',function() {
                jQuery(".scan-result-box").hide();
                jQuery('.scan-result-box-body').removeClass('removeBorder');
                jQuery.ajax({
                    url: "/ajax/submit/",
                    method: "POST",
                    data: {
                        sku: jQuery('#waited-tyres').val()
                    },
                    dataType:"json",
                    success: function (data) {
                        if(data["critical-message"] != null){
                            jQuery('#openModal').trigger("click");
                            jQuery("#messageInfo").html(data["critical-message"]);
                        }
                        jQuery("#historique-table").html(data["historique"]);
                        jQuery("#scan-result-box") .html(data["scan-result"]);
                        jQuery("#selectContainer").html(data["waited-tyres"]);
                        jQuery('#waited-tyres').select2();
                        setTimeout(function(){
                            jQuery('.scan-result-box-body').addClass('removeBorder');
                        },3000);
                        jQuery(".scan-result-box").show();

                    }
                });
            });

           /*
            * Gestion de la validation automatique lors du scan avec la douchette
            */
            jQuery('#scan-input').keyup(function(e) {
                if(e.keyCode == 13) {
                    jQuery(".scan-result-box").hide();
                    jQuery('.scan-result-box-body').removeClass('removeBorder');
                    jQuery.ajax({
                        url: "/ajax/submit/",
                        method: "POST",
                        data: {
                            ean: jQuery('#scan-input').val()
                        },
                        dataType:"json",
                        success: function (data) {
                            if(data["critical-message"] != null){
                                jQuery('#openModal').trigger("click");
                                jQuery("#messageInfo").html(data["critical-message"]);
                            }
                            jQuery("#scan-result-box").html(data["scan-result"]);
                            jQuery("#selectContainer").html(data["waited-tyres"]);
                            jQuery("#historique-table").html(data["historique"]);
                            console.log(data["historique"]);
                            jQuery('#waited-tyres').select2();

                            /*Temporisation de la disparition de la bordure rouge*/
                            setTimeout(function(){
                                jQuery('.scan-result-box-body').addClass('removeBorder');
                            },3000);

                            jQuery(".scan-result-box").show();
                            /*Supression de L'EAN déja scanné*/
                            setTimeout(function(){
                                jQuery('#scan-input').val("");
                            },2000);
                            jQuery('#scan-input').focus();
                        }
                    });
                }
            });

           /*
            * Gestion du clic sur le bouton re-imprimer
            */
            jQuery('.historique-table').on('click','#printAgain',function(){

                jQuery.ajax({
                    url: "/ajax/print/",
                    method: "POST",
                    data: {
                        histoId:jQuery(this).parent('td').parent('tr').data('histo-id')
                    },
                    dataType:"json",
                    success: function (data) {
                        jQuery(".historique-table").html(data["historique"]);
                    }
                });
            });

           /*
            * Gestion du clic sur le bouton voir Adresse
            */
            jQuery('.historique-table').on('click','#seeAdress',function(){
                jQuery.ajax({
                    url: "/ajax/seeAdress/",
                    method: "POST",
                    data: {
                        histoId:jQuery(this).parent('td').parent('tr').data('histo-id')
                    },
                    dataType:"json",
                    success: function (data) {
                        jQuery(".historique-table").html(data["historique"]);
                        jQuery('#openModalAdress').trigger("click");
                        jQuery("#adresseContent").html(data["adressInfo"]);
                    }
                });
            });
        });
        break;
    case "login":
        jQuery(document).ready(function(){
            jQuery("#submit-ident").click(function(){
                var content = "<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>";
                jQuery("#login-result").html(content);
                jQuery("#login-result").removeClass("errored-result");
                jQuery("#login-result").removeClass("hidden");
                jQuery.ajax({
                    url: "/ajax/login/",
                    method: "POST",
                    data: {
                        password: jQuery('#password').val(),
                        userName: jQuery('#userName').val()
                    },
                    dataType:"json",
                    success: function (data) {
                        if (data["status"]=="OK"){
                            window.location.replace(data["url"]);
                        }else if(data["status"]=="KO"){
                            jQuery("#login-result").html(data["message"]);
                            jQuery("#login-result").addClass("errored-result");
                        }

                    }
                });
            });
        });
        break;
    case "end":
        jQuery(document).ready(function(){
            if(jQuery('#myModal')){
                jQuery('#openModal').trigger("click");
            }
        });
    case "history":
        jQuery(document).ready(function(){

            jQuery('.historique-table').on('click','.printAgain',function(){

                jQuery.ajax({
                    url: "/ajax/print/",
                    method: "POST",
                    data: {
                        histoId:jQuery(this).parent('td').parent('tr').data('histo-id')
                    },
                    dataType:"json",
                    success: function (data) {
                        jQuery(".historique-table").html(data["historique"]);
                    }
                });
            });
        });
        break;
}


