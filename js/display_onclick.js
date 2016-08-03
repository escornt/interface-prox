$('#sub').click(function(){
  $('#sub-ok').removeClass('def-hidden');
  $('#sub').addClass('def-hidden');
});

$('#button-avance').click(function(){
  if ($('#sub-ok').hasClass('def-hidden')) {}
  $('#avance').removeClass('def-hidden');
} else {
  $('#avance').addClass('def-hidden');
}
});
