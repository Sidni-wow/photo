$(function()
{
    $(".heaet").on( "click",  function() {
		$(".plusOne",this).css({'margin-top':'0px','transition': '0s'});
        $(".plusOne",this).css({'visibility' : 'visible', 'margin-top':'-20px','transition': '0.7s'});
		$(".plusOne",this).css({'visibility' : 'hidden'});
    });
});