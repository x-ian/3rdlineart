$(function () {	
    $('.subnavbar').find ('li').each (function (i) {	
	var mod = i % 3;
	if (mod === 2) {
	    $(this).addClass ('subnavbar-open-right');
	}	
    });	
});
    $("[id*=date]").datepicker({
      changeYear: true,
      changeMonth: true,
      yearRange : 'c-65:c+10'
    });

