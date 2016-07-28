// ID VM
$('#i1').click(function(){
    if ($('#txt1').hasClass('def-hidden')) {
      $('#txt1').attr("def-hidden", "txt");
    }
    else {
      $('#txt1').attr("txt", "def-hidden");
    }
});
/*$('#txt1').ready(function(){
  $('#txt1').hide('fast');
});*/
// Nom VM
$('#i2').click(function(){
    if ($('#txt2').is(":visible")) {
        $('#txt2').addClass('def-hidden');
        $('#txt2').removeClass('txt');
      }
    else
    {
      $('#txt2').addClass('txt');
      $('#txt2').removeClass('def-hidden');
    }
});

// Description
$('#i3').click(function(){
    if ($('#txt3').is(":visible")) {
        $('#txt3').addClass('def-hidden');
        $('#txt3').removeClass('txt');
      }
    else
    {
      $('#txt3').addClass('txt');
      $('#txt3').removeClass('def-hidden');
    }
});

//Mot de passe
$('#i4').click(function(){
    if ($('#txt4').is(":visible")) {
        $('#txt4').addClass('def-hidden');
        $('#txt4').removeClass('txt');
      }
    else
    {
      $('#txt4').addClass('txt');
      $('#txt4').removeClass('def-hidden');
    }
});

// Confirmation mot de passe
$('#i5').click(function(){
    if ($('#txt5').is(":visible")) {
        $('#txt5').addClass('def-hidden');
        $('#txt5').removeClass('txt');
      }
    else
    {
      $('#txt5').addClass('txt');
      $('#txt5').removeClass('def-hidden');
    }
});

// Espace Disque
$('#i6').click(function(){
    if ($('#txt6').is(":visible")) {
        $('#txt6').addClass('def-hidden');
        $('#txt6').removeClass('txt');
      }
    else
    {
      $('#txt6').addClass('txt');
      $('#txt6').removeClass('def-hidden');
    }
});

// CPUs
$('#i7').click(function(){
    if ($('#txt7').is(":visible")) {
        $('#txt7').addClass('def-hidden');
        $('#txt7').removeClass('txt');
      }
    else
    {
      $('#txt7').addClass('txt');
      $('#txt7').removeClass('def-hidden');
    }
});

// RAM
$('#i8').click(function(){
    if ($('#txt8').is(":visible")) {
        $('#txt8').addClass('def-hidden');
        $('#txt8').removeClass('txt');
      }
    else
    {
      $('#txt8').addClass('txt');
      $('#txt8').removeClass('def-hidden');
    }
});

// Swap
$('#i9').click(function(){
    if ($('#txt9').is(":visible")) {
        $('#txt9').addClass('def-hidden');
        $('#txt9').removeClass('txt');
      }
    else
    {
      $('#txt9').addClass('txt');
      $('#txt9').removeClass('def-hidden');
    }
});
