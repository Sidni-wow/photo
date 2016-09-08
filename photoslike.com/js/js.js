
$(function(){	
	var countImgDiv = 12;
	idCateg = 0;
	$('.moreLoading').hide(); 
	$(".noUsers").hide();
	var idUser = getCookie("id");
   $(".addContent").on( 'click',".heaet",  function() {
		var thisEvent = this;
		var doubleThis = this.this;
		var idClick = $(this).attr('id');
		if(idUser == null){
			clickUsers();
			return;
		}
		var allLick;
		var elementE = $(".plusOne",thisEvent).parents('.borderThreeImg');
		$(".plusOne",thisEvent).css({"opacity":"1"});
			$.when( $(".plusOne",thisEvent).animate({
				marginTop: '-20px',
				opacity:'1'
			}, 300) ).then(function(){ 
				$(".plusOne",thisEvent).css({"margin-top":"0px","opacity":"0"});
				/*
				elementE.animate({
						opacity:'0',
						width:'0px',
						position:'absolute'
					}, 200);
				*/
			});
		$.ajax({
			url: "classes/likePlus.php",
			type: "POST",
			dataType: "json",
			data: {idU: idUser, idC: idClick},
			error: function(err){
					alert('falsewww');
			},
			success: function (data) { // вешаем свой обработчик на функцию success
				if(data[1] != 'a' && data[0] != 'f' && data[2] != 'l'){
					$(".progressBarOneDiv").animate({
						width:data[0]+'%'
					}, 100);
					$(".lvl").text(data[1] +" lvl");
					
						allLick = (data[1] * 100 + data[0]) + ' |'; 
						$(".allLick").text(allLick);
					
					$(".heaetLike b",thisEvent).text(data[2]);
				}
				
			} 
			
		})
		//elementE.detach();Удоление элемента по которому клацнули
		idCateg = getVarValueFromURL(document.location.href,"idC");
		//addList(idCateg);Добовление ного элемента в конец
		/*
			$(".plusOne",thisEvent).css({"opacity":"1"});
			$.when( $(".plusOne",this).animate({
				marginTop: '-20px',
				opacity:'1'
			}, 300) ).then(function(){ 
				$(".plusOne",thisEvent).css({"margin-top":"0px","opacity":"0"});
			});		
		*/
    });
	$(".addContent").on( 'click',".subscribe",  function() {
		if(idUser == null){
			clickUsers();
			return;
		}
		var idSubscribe = $(this).attr('id');
		$.ajax({
			url: "classes/subscribe.php",
			type: "POST",
			dataType: "json",
			data: {idS: idSubscribe, idU: idUser},
			error: function(err){
					alert('false');
			},
			success: function (data) { // вешаем свой обработчик на функцию success
				$(".del").css({"opacity":"1","z-index":"2000"});
				$(".del").animate({
						opacity:'0.0001',
						"z-index":"-2000"
				}, 1000); 
			} 
		});
    });
	$(".more").on( 'click',  function() {
		$('.moreLoading').show(); 	
		$('.more').hide();
		$.ajax({
			url: "classes/more.php",
			type: "POST",
			dataType: "json",
			error: function(err){
				$('.moreLoading').hide(); 	
				$('.more').show();
				$('.moreLoading').hide();
				console.log('err .more');
			},
			success: function (data) {
				for(var i = 0; i < 12;i+=3){
					$('body .content .addContent').append('<div class="row borderThreeImg"><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][i]+'"><div class="caption"><img src="'+data[1][i]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][i]+'</b></i><br /><i class="alias">'+data[3][i]+'</i></div></a><img src="img/loader.gif" class="loading"><div class="hoverC"><img src="img/hoverBackground.png" class="hoverComents"><div class="svetlyi"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+data[4][i]+'" alt="'+data[7][i]+'" class="im" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][i]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][i]+'" class="heaetLike"><b class="text-info">'+data[6][i]+'</b></div></i><div id="'+data[0][i]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][i+1]+'"><div class="caption"><img src="'+data[1][i+1]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][i+1]+'</b></i><br /><i class="alias">'+data[3][i+1]+'</i></div></a><img src="img/loader.gif" class="loading"><div class="hoverC"><img src="img/hoverBackground.png" class="hoverComents"><div class="svetlyi"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+data[4][i+1]+'" alt="'+data[7][i+1]+'" class="im" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][i+1]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][i+1]+'" class="heaetLike"><b class="text-info">'+data[6][i+1]+'</b></div></i><div id="'+data[0][i+1]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][i+2]+'"><div class="caption"><img src="'+data[1][i+2]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][i+2]+'</b></i><br /><i class="alias">'+data[3][i+2]+'</i></div></a><img src="img/loader.gif" class="loading"><div class="hoverC"><img src="img/hoverBackground.png" class="hoverComents"><div class="svetlyi"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+data[4][i+2]+'" alt="'+data[7][i+2]+'" class="im" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][i+2]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][i+2]+'" class="heaetLike"><b class="text-info">'+data[6][i+2]+'</b></div></i><div id="'+data[0][i+2]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div></div>');
				}
				$('.moreLoading').hide(); 	
				$('.more').show();
			} 
			
		});
	});
	$(".moreCategory").on( 'click',  function() {
		$('.moreLoading').show(); 	
		$('.moreCategory').hide();
		var idСategory = getVarValueFromURL(document.location.href,"idC");
		$.ajax({
			url: "classes/moreCategory.php",
			type: "POST",
			dataType: "json",
			data: {idC: idСategory, countImg: countImgDiv},
			error: function(err){
				$('body .err').append('<div style="font-weight:bold;padding:10px;color:dodgerblue;text-align:center;"> Все фото в этой категории </div>');
				$('.moreCategory').hide();
				$('.moreLoading').hide();
				console.log('err .moreCategory');
			},
			success: function (data) {
				$('.moreLoading').hide();
				$('.moreCategory').show();
				if((data == ",,,,,,")){
					$('body .err').append('<div style="font-weight:bold;padding:10px;color:dodgerblue;text-align:center;"> Все фото в этой категории </div>');
					$('.moreCategory').hide();
					exit;
				}
				var len = data[0].length;
				
				for(var i = 0; i < len; i+=3){
					$('body .content .addContent').append('<div class="row borderThreeImg"><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][i]+'"><div class="caption"><img src="'+data[1][i]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][i]+'</b></i><br /><i class="alias">'+data[3][i]+'</i></div></a><img src="img/loader.gif" class="loading"><div class="hoverC"><img src="img/hoverBackground.png" class="hoverComents"><div class="svetlyi"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+data[4][i]+'" alt="'+data[7][i]+'" class="im" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][i]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][i]+'" class="heaetLike"><b class="text-info">'+data[6][i]+'</b></div></i><div id="'+data[0][i]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][i+1]+'"><div class="caption"><img src="'+data[1][i+1]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][i+1]+'</b></i><br /><i class="alias">'+data[3][i+1]+'</i></div></a><img src="img/loader.gif" class="loading"><div class="hoverC"><img src="img/hoverBackground.png" class="hoverComents"><div class="svetlyi"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+data[4][i+1]+'" alt="'+data[7][i+1]+'" class="im" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][i+1]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][i+1]+'" class="heaetLike"><b class="text-info">'+data[6][i+1]+'</b></div></i><div id="'+data[0][i+1]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][i+2]+'"><div class="caption"><img src="'+data[1][i+2]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][i+2]+'</b></i><br /><i class="alias">'+data[3][i+2]+'</i></div></a><img src="img/loader.gif" class="loading"><div class="hoverC"><img src="img/hoverBackground.png" class="hoverComents"><div class="svetlyi"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+data[4][i+2]+'" alt="'+data[7][i+2]+'" class="im" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][i+2]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][i+2]+'" class="heaetLike"><b class="text-info">'+data[6][i+2]+'</b></div></i><div id="'+data[0][i+2]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div></div>');
				}
				if(len < 12){
					$('body .err').append('<div style="font-weight:bold;padding:10px;color:dodgerblue;text-align:center;"> Все фото в этой категории </div>');
					$('.moreCategory').hide();
				}
				countImgDiv += 12;
			}
		});
	});
	$(".moreView").on( 'click',  function() {
		$('.moreLoading').show(); 	
		$('.moreView').hide();
		var idUs = getVarValueFromURL(document.location.href,"id");
		if(idUs == null){
			idUs = getCookie('id');
		}
		$.ajax({
			url: "classes/addImg.php",	
			type: "POST",
			dataType: "json",
			data: {idU: idUs, countImg: countImgDiv},
			error: function(err){
				$('body .addImg').append('<div style="font-weight:bold;padding:10px;color:dodgerblue;text-align:center;"> Все фото </div>');
				$('.moreView').hide();
				$('.moreLoading').hide();
				console.log('err .moreView');
			},
			success: function (data) {
				$('.moreLoading').hide();
				$('.moreView').show();
				if((data == ",")){
					$('body .addImg').append('<div style="font-weight:bold;padding:10px;color:dodgerblue;text-align:center;"> Все фото </div>');
					$('.moreView').hide();
					exit;
				}
				var len = data[0].length;
				
				for(var i = 0; i < len; i+=3){
					$('body .addImg').append('<div class="row"><div class="col-xs-4 col-sm-4"><div class="thumbnail"><img src="img/loader.gif" class="loading"><div class="hoverPageUsers" value="'+data[4][i]+'"><img src="img/hoverBackground.png" value="'+data[6][i]+'" class="hoverComentsUs"><div class="svetlyi" value="'+data[3][i]+'"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+ data[0][i] +'" alt="'+ data[1][i] +'" id="'+ data[2][i] +'" value="'+ data[5][i] +'" class="imU" onLoad="loadImg(this)"></div></div><div class="col-xs-4 col-sm-4"><div class="thumbnail"><img src="img/loader.gif" class="loading"><div class="hoverPageUsers" value="'+data[4][i+1]+'"><img src="img/hoverBackground.png" value="'+data[6][i+1]+'" class="hoverComentsUs"><div class="svetlyi" value="'+data[3][i+1]+'"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+ data[0][i+1] +'" alt="'+ data[1][i+1] +'" id="'+ data[2][i+1] +'" value="'+ data[5][i+1] +'" class="imU" onLoad="loadImg(this)"></div></div><div class="col-xs-4 col-sm-4"><div class="thumbnail"><img src="img/loader.gif" class="loading"><div class="hoverPageUsers" value="'+data[4][i+2]+'"><img src="img/hoverBackground.png" value="'+data[6][i+2]+'" class="hoverComentsUs"><div class="svetlyi" value="'+data[3][i+2]+'"><span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span></div></div><img src="'+ data[0][i+2] +'" alt="'+ data[1][i+2] +'" id="'+ data[2][i+2] +'" value="'+ data[5][i+2] +'" class="imU" onLoad="loadImg(this)"></div></div></div>');
				}
				if(len < 12){
					$('body .addImg').append('<div style="font-weight:bold;padding:10px;color:dodgerblue;text-align:center;"> Все фото </div>');
					$('.moreView').hide();
				}
				countImgDiv += 12;
			}
		});
	});
	function getVarValueFromURL(url, varName) {
		var query = url.substring(url.indexOf('?') + 1);
		var vars = query.split("&");
		for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
			if (pair[0] == varName) {
			  return pair[1];
			}
		}
		return null;
	}
	function addList(idCateg){
		$.ajax({
			url: "classes/addList.php",
			type: "POST",
			dataType: "json",
			data: {idCateg: idCateg, countImg:countImgDiv},
			error: function(err){
					alert('falses');
			},
			success: function (data) {
				if((data == ",,,,,,")){
					$('body .err').append('<div style="font-weight:bold;padding:10px;color:dodgerblue;text-align:center;"> Все фото в этой категории</div>');
					$('.moreCategory').hide();
					exit;
				}
				$('body .content .addContent').append('<div class="row borderThreeImg"><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][0]+'"><div class="caption"><img src="'+data[1][0]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][0]+'</b></i><br /><i class="alias">'+data[3][0]+'</i></div></a><img src="img/loader.gif" class="loading"><img src="'+data[4][0]+'" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][0]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][0]+'" class="heaetLike"><b class="text-info">'+data[6][0]+'</b></div></i><div id="'+data[0][0]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][1]+'"><div class="caption"><img src="'+data[1][1]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][1]+'</b></i><br /><i class="alias">'+data[3][1]+'</i></div></a><img src="img/loader.gif" class="loading"><img src="'+data[4][1]+'" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][1]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][1]+'" class="heaetLike"><b class="text-info">'+data[6][1]+'</b></div></i><div id="'+data[0][1]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div><div class="col-xs-4 col-sm-4"><div class="thumbnail"><a href="?option=view&id='+data[0][2]+'"><div class="caption"><img src="'+data[1][2]+'"class="minAva" ><i class="textMinAva"><b>'+data[2][2]+'</b></i><br /><i class="alias">'+data[3][2]+'</i></div></a><img src="img/loader.gif" class="loading"><img src="'+data[4][2]+'" onLoad="loadImg(this)" ><div class="caption"><i id="'+data[5][2]+'" class="glyphicon glyphicon-heart navbar-brand right heaet"><span class="right plusOne">+1</span><div id="'+data[0][2]+'" class="heaetLike"><b class="text-info">'+data[6][2]+'</b></div></i><div id="'+data[0][2]+'" class="subscribe"><b>Подписаться</b></div><br /></div></div></div></div>');
				if(idCateg != ""){
					countImgDiv += 3;
				}
			} 
			
		});
	}
	function clickUsers(){
		$(".noUsers").show(300);
		$(".noUsers").css("border","1px solid red");
	}
	$(".exit").on( "click",  function() {  
		document.cookie = "id" + "=" + "; expires=Thu, 01 Jan 1970 00:00:01 GMT";
		document.cookie = "idCheck" + "=" + "; expires=Thu, 01 Jan 1970 00:00:01 GMT";
		window.location = "?option=login";
	});
	$(".uploadAva").on( "click",  function() {  
		window.location = "?option=uploadAva";
	});
	function getCookie(name){
		var cookie = " " + document.cookie;
		var search = " " + name + "=";
		var setStr = null;
		var offset = 0;
		var end = 0;
		
		if (cookie.length > 0)
		{
			offset = cookie.indexOf(search);
			if (offset != -1)
			{
				offset += search.length;
				end = cookie.indexOf(";", offset)
				if (end == -1)
				{
					end = cookie.length;
				}
				setStr = unescape(cookie.substring(offset, end));
			}
		}
		return(setStr);
	}
	
	jQuery(function(f){
		var element = f('.noUsers');
		f(window).scroll(function(){
			element['fade'+ (f(this).scrollTop() > 200 ? 'In': 'Out')](100);           
		});
	});
	$(".addContent").on( 'click',".thumbnail .hoverC",  function() {
		var text = $(this).siblings('.caption');
		var idPhotos = $('.heaet',text).attr("id");
		//var idPhotos_S_H = ;
		
		if($('.photoComments').hasClass('ID'+idPhotos)){
			$('.ID'+idPhotos).show();
		}else{
			
			var user = $(this).siblings('a');
			var hrefUser = user.attr("href");
			var alt = $(this).siblings('.im').attr("alt");
			user = $('div',user);
			var dataUser = new Array($('img',user).attr("src"),hrefUser,$('.textMinAva',user).text(),$('.alias',user).text());
			
			var src = $(this).siblings('.im').attr("src");
			$('body').append('<div class="photoComments backgrBlack ID'+idPhotos+'"><div class="margCenter"><img class="close" src="img/close.png"><div class="col-xs-6 col-sm-6 photo esc"><img style="" src="'+src+'"></div><div class="comments esc"><div class="caption comment"><a href="'+dataUser[1]+'"><img src="'+dataUser[0]+'" class="minAva" alt="'+alt+'"><i class="textMinAva"><b> '+dataUser[2]+'</b></i><br><i class="alias"> '+dataUser[3]+'</i></a><p><b>Описание:</b> '+alt+'</p><div class="usersCom" value="0"></div></div><div class="myComent"><textarea style="width:90%;float:left;" required placeholder="Коментарий"></textarea><input style="" class="btn btn-default btn-sm inputComent" id="'+idPhotos+'" value="←" type="submit"/></div></div></div>');
			$('.ID'+idPhotos+' .usersCom').append('<img class="loa" src="../img/loadCom.gif">');
			$.ajax({
					url: "classes/Coments.php",
					type: "POST",
					dataType: "json",
					data: {idPhoto: idPhotos},
					error: function(err){
							alert('false');
					},
					success: function (data) {
						$('.ID'+idPhotos+' .usersCom .loa').remove();
						if(data == "true"){
							$('.ID'+idPhotos+' .usersCom').append('<p class="notComent">Комментариев нету, оставьте свой</p>');
						}else{
							
							//array (["id","Min ava","Alias","name","coment"]);
							//alert(data);
							var countCom = 0;
							for(var i = 0; i < data[0]; i+=1){
								data[i+1][4] = data[i+1][4].replace(/\\/ig, '');
								$('.ID'+idPhotos+' .usersCom').append('<div class="hr"></div><a href="?option=view&id='+data[i+1][0]+'"><img src="'+data[i+1][1]+'" class="minAva" ><i class="textMinAva"><b> '+data[i+1][3]+'</b></i><br><i class="alias"> '+data[i+1][2]+'</i></a><p> '+data[i+1][4]+'</p>');
							}
							countCom = parseInt($('.ID'+idPhotos+' .usersCom').attr("value"));
							//alert(countCom);
							countCom += data[0];
							$('.ID'+idPhotos+' .usersCom').attr("value",countCom);
							
						}
						//$('.ID'+idPhotos+' .usersCom').append('');
					}
				});
		}
	});
	//$(".addContent")
	$(".addImg").on( 'click',".thumbnail .hoverPageUsers",  function() {
		var text = $(this).siblings('.imU');
		var idPhotos = text.attr("id");
		//var idPhotos_S_H = ;
		
		if($('.photoComments').hasClass('ID'+idPhotos)){
			$('.ID'+idPhotos).show();
		}else{
			var hrefUser = "?option=view&id="+$(".svetlyi",this).attr("value");
			//alert(hrefUser);
			var alt = text.attr("alt");
			var dataUser = new Array($("img",this).attr("value"),hrefUser,$(this).attr("value"),text.attr("value"));
			var src = text.attr("src");
			
			$('body').append('<div class="photoComments backgrBlack ID'+idPhotos+'"><div class="margCenter"><img class="close" src="img/close.png"><div class="col-xs-6 col-sm-6 photo esc"><img style="" src="'+src+'"></div><div class="comments esc"><div class="caption comment"><a href="'+dataUser[1]+'"><img src="'+dataUser[0]+'" class="minAva" alt="'+alt+'"><i class="textMinAva"><b> '+dataUser[2]+'</b></i><br><i class="alias"> '+dataUser[3]+'</i></a><p><b>Описание:</b> '+alt+'</p><div class="usersCom" value="0"></div></div><div class="myComent"><textarea style="width:90%;float:left;" required placeholder="Коментарий"></textarea><input style="" class="btn btn-default btn-sm inputComent" id="'+idPhotos+'" value="←" type="submit"/></div></div></div>');
			$('.ID'+idPhotos+' .usersCom').append('<img class="loa" src="../img/loadCom.gif">');
			$.ajax({
					url: "classes/Coments.php",
					type: "POST",
					dataType: "json",
					data: {idPhoto: idPhotos},
					error: function(err){
							alert('false');
					},
					success: function (data) {
						$('.ID'+idPhotos+' .usersCom .loa').remove();
						if(data == "true"){
							$('.ID'+idPhotos+' .usersCom').append('<p class="notComent">Комментариев нету, оставьте свой</p>');
						}else{
							
							//array (["id","Min ava","Alias","name","coment"]);
							//alert(data);
							var countCom = 0;
							for(var i = 0; i < data[0]; i+=1){
								$('.ID'+idPhotos+' .usersCom').append('<div class="hr"></div><a href="?option=view&id='+data[i+1][0]+'"><img src="'+data[i+1][1]+'" class="minAva" ><i class="textMinAva"><b> '+data[i+1][3]+'</b></i><br><i class="alias"> '+data[i+1][2]+'</i></a><p> '+data[i+1][4]+'</p>');
							}
							countCom = parseInt($('.ID'+idPhotos+' .usersCom').attr("value"));
							//alert(countCom);
							countCom += data[0];
							$('.ID'+idPhotos+' .usersCom').attr("value",countCom);
							
						}
						//$('.ID'+idPhotos+' .usersCom').append('');
					}
				});
		}
	});
	$(document).mouseup(function (e){
		var click = $(".esc");
		if (!click.is(e.target) && click.has(e.target).length === 0) {
			$('.photoComments').hide();
		}
	});
	
	$("body").on( 'click',".inputComent",  function() {
		
		var textArea = $(this).siblings('textArea').val();
		//alert(textArea);
		var idPhCom = $(this).attr("id");
		var countCome = parseInt($('.ID'+idPhCom+' .usersCom').attr("value"));
		
		//alert(0);
		var r=/\s+/g;
		var n=/\\n\r+/g;
		textArea = textArea.replace(r,' ');
		textArea = textArea.replace(n,'\n\r');
		if(textArea == " " || textArea == "" || textArea.length > 1001){
			$(this).siblings('textArea').css({"border":"1px solid red"});
		}else{
			$('.ID'+idPhCom+' .inputComent').hide();
			$('.ID'+idPhCom+' .myComent').append('<img class="loaInput" src="../img/loadCom.gif">');
			$(this).siblings('textArea').css({"border":"1px solid transparent"});
			$.ajax({
				url: "classes/addComents.php",
				type: "POST",
				dataType: "json",
				data: {idPhoto: idPhCom, coment: textArea, count:countCome},
				error: function(err){
						alert('false');
				},
				success: function (data) {
					$('.ID'+idPhCom+' .inputComent').show();
					$('.ID'+idPhCom+' .myComent .loaInput').hide();
					
					if(data == "reg"){
						$('.ID'+idPhCom+' .usersCom .reg1q').remove();
						$('.ID'+idPhCom+' .usersCom').prepend('<div class="reg1q" style="color:red;"><p>Войдите в аккаунт, чтобы оставлять комментарии</p></div>');
						return;
					}
					$('.ID'+idPhCom+' .usersCom .notComent').remove();
					$('.ID'+idPhCom+' .usersCom .reg1q').remove();
					for(var i = 0; i < data[0]; i+=1){
						data[i+1][4] = data[i+1][4].replace(/\\/ig, '');
						$('.ID'+idPhCom+' .usersCom').prepend('<div class="hr"></div><a href="?option=view&id='+data[i+1][0]+'"><img src="'+data[i+1][1]+'" class="minAva" ><i class="textMinAva"><b> '+data[i+1][3]+'</b></i><br><i class="alias"> '+data[i+1][2]+'</i></a><p> '+data[i+1][4]+'</p>');
					}
					
					$('.ID'+idPhCom+' .usersCom').attr("value",countCome+(data[0]));
					
				}
			});
			$(this).siblings('textArea').val("");
		}
	});
});
function loadImg(elem){
      $(elem).siblings('.loading').hide();
}
//гугл
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-82105874-1', 'auto');
  ga('send', 'pageview');

