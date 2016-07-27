/*$('#i1').click(function(){

    if ($('#txt1').is(":visible")){
        $('#txt1').hide();
    }
    else
    {
        $('#txt1').show();
    }

});*/

$("#i1").mouseenter(function(){
    $('txt1').show();
});

$("#i1").mouseleave(function(){
    $('txt1').hide();
});

$('#txt1').load(function(){
  $('#txt1').hide();
});
