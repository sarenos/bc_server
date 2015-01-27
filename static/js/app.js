$(document).ready(function(){
   
    $('.table_content').find('>div:last-child').hide();
	$('.table_content').click( function(){
	   $('.table_content').find('>div:last-child').hide();
       $('.table_content').find('>div:first-child').css('background-color','#F3F3F3');
	   $(this).find('>div:first-child').css('background-color','#32819A');
       $(this).find('>div:last-child').toggle();
       $(this).parents('.content_data')
	});
    
});