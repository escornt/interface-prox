$('#i1').click(function(){

    if ($('#txt1').is(":visible")){
        $('#txt1').hide();
    }
    else
    {
        $('#txt1').show();
    }

});


$('#txt1').ready(function(){
  $('#txt1').hide();
});
