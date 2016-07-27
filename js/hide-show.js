/*$('#i1').click(function(){

    if ($('#txt1').is(":visible")){
        $('#txt1').hide();
    }
    else
    {
        $('#txt1').show();
    }

});*/

$("#i1").hover(function(){
    $('txt1').show();
},
function(){
    $('txt1').hide();
});

$('#txt1').load(function(){
  $('#txt1').hide();
});
