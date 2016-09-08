/**
 * HTML5 Image uploader with Jcrop
 */

// convert bytes into friendly format

function bytesToSize(bytes) {
    var sizes = ['Bytes', 'KB', 'MB'];
    if (bytes == 0) return 'n/a';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];
};

// check for selected crop region
function checkForm() {
	$('.inpImgLoad').show();
	$(".getCategory").show();
	$('.inpImg').hide();
    if (parseInt($('#w').val())) return true;
	$('.inpImg').show();
	$('.inpImgLoad').hide();
	 $(".getCategory").hide();
    $('.error').html('Пожалуйста, выберите размер для изображения').show();
    return false;
};

// update info by cropping (onChange and onSelect events handler)
function updateInfo(e) {
    $('#x1').val(e.x);
    $('#y1').val(e.y);
    $('#x2').val(e.x2);
    $('#y2').val(e.y2);
    $('#w').val(e.w);
    $('#h').val(e.h);
};

// clear info by cropping (onRelease event handler)
function clearInfo() {
    $('.info #w').val('');
    $('.info #h').val('');
};

function fileSelectHandler() {
	
	$(".step2").empty();	//"+ /* style='visibility:hidden;*/ +"
	$(".step2").append("<h2>Укажите область выделения</h2><img id='preview'><div class='info'><p> <label>Тип</label> <input type='text' id='filetype' name='filetype'><label>Размер изображения</label> <input type='text' id='filedim' name='filedim'></p><p style='visibility:hidden;'><label>Ширина</label> <input type='text' id='w' name='w'><label>Высота</label> <input type='text' id='h' name='h'></p></div><select size='1' class='turnintodropdown' name='category'><option disabled selected>Выберите категорию</option><option value='29'>Аниме</option><option value='23'>Гаджеты</option><option value='13'>Гики</option><option value='14'>Дизайн</option><option value='27'>Еда и напитки</option></option><option value='15'>Женская мода</option><option value='17'>Животные</option><option value='18'>Здоровье и фитнес</option><option value='19'>Знаменитости</option><option value='30'>Игры</option><option value='20'>Искусство</option><option value='21'>История</option><option value='22'>Кино, музыка, книги</option><option value='28'>Космос </option><option value='25'>Машины и мотоциклы</option><option value='1'>Мода</option><option value='16'>Мода для мужчин</option><option value='9'>Мемы</option><option value='26'>Наука</option><option value='2'>Обучение</option><option value='24'>Подарки</option><option value='3'>Праздники</option><option value='5'>Природа</option><option value='4'>Путешествия</option><option value='6'>Сделай сам</option><option value='31'>Селфи</option><option value='7'>Спорт</option><option value='8'>Татуировки</option><option value='10'>Фотографии</option><option value='11'>Цитаты</option><option value='12'>Юмор</option></select><br /><br /><div class='input-group'><span class='input-group-addon mobil'>Описание</span><input type='text' class='form-control description' name='description' placeholder='Описание'></div><br /><br /><input type='submit' class='inpImg' value='Готово'><div class='inpImgLoad'>Загрузка, пожалуйста подождите</div>");
	tamingselect(); // стили для select
	// get selected file
    var oFile = $('#image_file')[0].files[0];
	
    // hide all errors
    $('.error').hide();
	$('.inpImgLoad').hide();
	 $(".getCategory").hide();
    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png)$/i;
    if (! rFilter.test(oFile.type)) {
        $('.error').html('Пожалуйста, выберите файл (разрешено JPG, PNG).').show();
        return;
    }

    // check for file size
    if (oFile.size > 2000 * 1024) {
        $('.error').html('Ваш файл слишком велик, максимальный вес 2MB').show();
        return;
    }

    // preview element
    var oImage = document.getElementById('preview');

    // prepare HTML5 FileReader
    var oReader = new FileReader();
        oReader.onload = function(e) {
		
        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler

            // display step 2
            $('.step2').fadeIn(500);

            // display some basic image info
            var sResultFileSize = bytesToSize(oFile.size);
            
            $('#filetype').val(oFile.type);
            $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);

            // Create variables (in this scope) to hold the Jcrop API and image size
            var jcrop_api, boundx, boundy;

            // destroy Jcrop if it is existed
            if (typeof jcrop_api != 'undefined') 
                jcrop_api.destroy();

            // initialize Jcrop
            $('#preview').Jcrop({
                minSize: [400, 240], // min crop size
                aspectRatio : 1.669, // keep aspect ratio 1:1
                bgFade: true, // use fade effect
                bgOpacity: .3, // fade opacity
                onChange: updateInfo,
                onSelect: updateInfo,
                onRelease: clearInfo
            }, function(){

                // use the Jcrop API to get the real image size
                var bounds = this.getBounds();
                boundx = bounds[0];
                boundy = bounds[1];
				if(boundy < 240 || boundx < 400){
					$('.error').html('Пожалуйста, выберите фотографию минимальное разрешение 400x240 точек.').show();
					$(".step2").empty();
					$(".getCategory").hide();
					
				}
                // Store the Jcrop API in the jcrop_api variable
                jcrop_api = this;
            });
        };
    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
	
}