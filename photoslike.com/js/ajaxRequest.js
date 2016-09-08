$(function()
{
    $(".heaet").on( "click",  function() {
		//Нужно позже дописать потомучто ещё куки нужно сделать	
		//Так как нужно отследить кто кликает
		$.ajax({
		  type: "POST",
		  url: "phpFunc/likePhoto.php",
		  data: data,
		  success: success,
		  dataType: dataType
		});
	});
});