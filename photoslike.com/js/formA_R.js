//action
var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
function formdata(data){
	var res = true;
	if(data.email.value != '') {
		if(pattern.test(data.email.value)){			
			$(this).css({'border' : '1px solid #31708f'});
			$('.validResEmail').text('✔');
		} else {
			$(this).css({'border' : '1px solid #ff0000'});
			$('.validResEmail').text('✘');
			res = false;
		}
	}else{
		$(this).css({'border' : '1px solid #ff0000'});
		$('.validResEmail').text('✘');
		res = false;
	}
	
	if(data.pass.value.length < 4) {
		$('.validResPass').text('✘');
		res = false;
	}else if(data.name.value.length < 2) {
		$('.validResName').text('✘');
		res = false;
	}else if(data.alias.value.length < 2) {
		$('.validResAlias').text('✘');
		res = false;
	}
	return res;
}
function formdataAvt(data){
	var res = true;
	if(data.emailLogin.value != '') {
		if(pattern.test(data.email.value)){			
			$(this).css({'border' : '1px solid #31708f'});
			$('.validAvtEmail').text('✔');
		} else {
			$(this).css({'border' : '1px solid #ff0000'});
			$('.validAvtEmail').text('✘');
			res = false;
		}
	}else{
		$(this).css({'border' : '1px solid #ff0000'});
		$('.validAvtEmail').text('✘');
		res = false;
	}
	if(data.passLogin.value.length < 4) {
		$('.validAvtPass').text('✘');
		res = false;
	}
	return res;
}

//blur
$(document).ready(function() {
	$('body').css({'background' : '#f3f3f3'});
	$('#emailAvt').blur(function() {
		
		if($(this).val() != '') {
			
			if(pattern.test($(this).val())){
				$(this).css({'border' : '1px solid #31708f'});
				$('.validAvtEmail').text('✔');
			} else {
				$(this).css({'border' : '1px solid #ff0000'});
				$('.validAvtEmail').text('✘');
			}
		}else{
			$(this).css({'border' : '1px solid #ff0000'});
			$('.validAvtEmail').text('✘');
		}
	});
	$('#passAvt').blur(function() {
		if($(this).val().length >= 4) {
			$(this).css({'border' : '1px solid #31708f'});
			$('.validAvtPass').text('✔');
		}else{
			$(this).css({'border' : '1px solid #ff0000'});
			$('.validAvtPass').text('✘');
		}
	});
	$('#email').blur(function() {
		if($(this).val() != '') {
			
			if(pattern.test($(this).val())){
				$(this).css({'border' : '1px solid #31708f'});
				$('.validResEmail').text('✔');
			} else {
				$(this).css({'border' : '1px solid #ff0000'});
				$('.validResEmail').text('✘');
			}
		}else{
			$(this).css({'border' : '1px solid #ff0000'});
			$('.validResEmail').text('✘');
		}
	});
	$('#pass').blur(function() {
		if($(this).val().length >= 4) {
			$(this).css({'border' : '1px solid #31708f'});
			$('.validResPass').text('✔');
		}else{
			$(this).css({'border' : '1px solid #ff0000'});
			$('.validResPass').text('✘');
		}
	});
	$('#name').blur(function() {
		if($(this).val().length >= 2) {
			$(this).css({'border' : '1px solid #31708f'});
			$('.validResName').text('✔');
		}else{
			$(this).css({'border' : '1px solid #ff0000'});
			$('.validResName').text('✘');
		}
	});
	$('#alias').blur(function() {
		if($(this).val().length >= 2) {
			$(this).css({'border' : '1px solid #31708f'});
			$('.validResAlias').text('✔');
		}else{
			$(this).css({'border' : '1px solid #ff0000'});
			$('.validResAlias').text('✘');
		}
	});
});