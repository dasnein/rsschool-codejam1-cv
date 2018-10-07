  $(document).ready(function() {

	//	Плавная прокрутка
	$('.parallax').on('click', function(event) {
		event.preventDefault();
		$('html, body').animate({scrollTop: ($($(this).attr('href')).eq(0).offset().top)/*-$('header').height()*/}, 500);
	});




	//	Отключаем увеличение
	$('[data-fancybox="gallery"]').fancybox({
		clickContent: false
	});




	//	Вводим имя файла при его выборе
	$('input[type=file]').on('change', function(event) {
		var filename = $(this).val().split('\\').pop();
		
		if (filename.indexOf('.exe') > 0) {
			event.preventDefault();
			alert('Exe файлы запрещены для отправки!');
		} else {
			$(this).parent('label').children('span').html(filename);
		}

		if (this.files[0].size / 1000000 > 10) {
			event.preventDefault();
			alert('Файлы больше 10 Мб запрещены для отправки!');
			form_error = true;
		} else {
			$(this).parent('label').children('span').html(filename);
		}


		console.log(filename);
		console.log( this.files[0].size / 1000000 );
	});


	//	Запрет ввода букв в поле телефон
	$('[type=tel]').keypress(function(e) {
		if (e.which != 8 && e.which != 0 && e.which != 46 && e.which != 43 && e.which != 45 && (e.which < 48 || e.which > 57)) {
			return false;
		}
	});

	//	Проверяем поле телефон если вставлены символы
	$('[type=tel]').keyup(function(event) {
		$(this).val($(this).val().replace(/[^0-9\+\-]+/g, ""));
	});


	/*   MODAL FORMS   */
		//	Открытие и закрытие
		$('a[data-fancybox]').on('click', function(event) {
			if ($(this).data('form')) {
				$($(this).attr('href')).find('input[name=form]').val($(this).data('form'));
			} else {
				if ($($(this).attr('href')).data('form-default')) {
					$($(this).attr('href')).find('input[name=form]').val($($(this).attr('href')).data('form-default'));
				}
			}
		});

		//	Отправка формы
		$('form').on('submit', function(event) {
			event.preventDefault();
			var error = false;
			$(this).find('input').each(function () {
				if ($(this).attr('required') && $(this).val().length < 3) {
					error = true;
					$(this).addClass('input_error');
					console.log('error');
				} else {
					$(this).removeClass('input_error');
				}
			});

			if (error) {
				var nav = navigator.userAgent;
				if (nav.indexOf('Safari') > -1) {
					alert('Заполните поля "Имя" и "Телефон" !');
				}
			}

			if ($(this).children('input[type=tel]').val().replace(/\d/g, '').replace(/\+/g, '').length > 0) {
				alert('Введите в поле "Телефон" только цифры и знак плюс!');
				error = true;
			}

			if (!error) {

				if(!window.FormData) {
					console.log('Ваш браузер не поддерживает загрузку файлов!');
				}

				$(this).find('button[type=submit]').addClass('load').attr('disabled');
				$(this).attr('id', 'currentform');


				form = document.forms.currentform;
				var	formData = new FormData(form),
					xhr = new XMLHttpRequest();

					console.log(form);

				xhr.open("POST", window.location.href + "js/send.php");
				
				xhr.onreadystatechange = function() {
					console.log(xhr.responseText);

					if (xhr.readyState == 4) {
						if(xhr.status == 200) {
							console.log('form sent!!');
							$.fancybox.close('all');
							$.fancybox.open($('#modal-form-thanx').parent('div').html());
							$('#currentform').find('button[type=submit]').removeClass('load').removeAttr('disabled');
							//	Обнуляем значения input
								let childNodes = document.querySelectorAll('#currentform input');
								childNodes.forEach(function (el) {
									el.value = '';
								});
							$('#currentform').removeAttr('id');
						}
					}
				};
				xhr.send(formData);
			}
		});



});



$(window).on('scroll', function(event) {

	var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

});