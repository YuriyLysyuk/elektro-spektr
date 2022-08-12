document.addEventListener("DOMContentLoaded", () => {
	// Custom JS

	// Фиксированный хедер
	var limit = 200,
		topLine = $('.top-line'),
		topLinePlaceholder = $('.top-line-placeholder');

	// .top-line-placeholder нужен чтобы небыло скачка в верстке при прокрутке, он равен оригинальному .top-line
	topLinePlaceholder.css('height', topLine.outerHeight());

	$(window).scroll(function () {
		if ($(this).scrollTop() >= limit) {
			topLine.addClass('fixed');
		} else {
			topLine.removeClass('fixed');
		}
	});

	// Главный слайдер
	$("#top-slider").owlCarousel({
		loop: true,
		autoplay: true,
		autoplayHoverPause: true,
		nav: true,
		navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
		dots: true,
		items: 1,
		responsive: {
			0: {
				items: 1,
				nav: false
			},
			480: {
				nav: true
			}
		}
	});

	// Ставим доты слайдера на сам слайдер по центру
	var topSliderDots = $('#top-slider .owl-dots');
	topSliderDots.css('left', 'calc(50% - ' + topSliderDots.width() / 2 + 'px)');

	// Cлайдер категории
	$("#category-slider").owlCarousel({
		loop: true,
		autoplay: true,
		autoplayHoverPause: true,
		margin: 16,
		nav: true,
		navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
		dots: false,
		responsive: {
			0: {
				items: 1,
				nav: false
			},
			480: {
				items: 1,
			},
			768: {
				items: 2,
			},
			992: {
				items: 3,
			},
			1200: {
				items: 4,
			}
		}
	});

	// Инициализируем общее модальное окно
	let modalCommon = $("#modal-common");

	modalCommon.iziModal({
		width: 450,
		headerColor: "#051937",
		closeOnEscape: true,
		closeButton: true,
		overlayColor: "rgba(0, 0, 0, 0.9)",
		bodyOverflow: true,
	});

	// Инициализируем окно Спасибо
	$("#modal-thankyou").iziModal({
		icon: 'fas fa-check-circle',
		headerColor: '#00a88c',
		width: 600,
		timeout: 5000,
		timeoutProgressbar: true,
		transitionIn: 'fadeInDown',
		transitionOut: 'fadeOutDown',
		pauseOnHover: true
	});

	// Открываем модальное окно при клике на ссылку
	$(document).on('click', '.open-modal-common', function (event) {
		event.preventDefault();

		// Получаем атрибуты для изменения из ссылки
		let currentLink = $(this);
		let modalTitle = currentLink.data("modal-title");
		let modalButton = $(".modal-common__button");
		let modalButtonText = currentLink.data("modal-button-text");
		let hiddenWhat = $(".modal-common__what");

		if (modalTitle) {
			modalCommon.iziModal('setTitle', modalTitle);
			hiddenWhat.val(modalTitle);
		}

		if (modalButtonText) {
			modalButton.html(modalButtonText);
		}

		modalCommon.iziModal('open');
	});



	// Маска для телефона
	$(".masked-phone").mask("+7 (999) 999-99-99");

	// 	Отправка всех форм на сайте
	$('.form-order').on('submit', function () {
		var self = $(this);
		self.find("button[type='submit']").prop('disabled', true);
		var send_data = self.serialize();
		$.ajax({
			type: "POST",
			url: '/mail/mail.php',
			data: send_data,
			success: function (result) {
				// console.log(result);
				if (result == 'success') {
					// console.log('Успешная отправка');
					self.find('input[name=Имя]').val('');
					self.find('input[name=Телефон]').val('');
					self.find('input[name=Email]').val('');
					self.find('input[name=Комментарий]').val('');
					self.find("button[type='submit']").prop('disabled', false);
					modalCommon.iziModal('close');
					$('#modal-thankyou').iziModal('open');
				} else {
					// console.log('Неудачная отправка');
				}
			}
		});

		return false;
	});

	// Фильтр товаров
	// Размещен в partials/block-subcategory-filter.php
	// Для мобильных добавляем переключатель видимости фильтра
	if ($(document).width() < 992) {
		$('.subcategory-filter .h3').click(function () {
			if ($('.subcategory-filter__tabs:visible').length) {
				$('.subcategory-filter__tabs').hide();
				$('.subcategory-filter__reset').hide();
			} else {
				$('.subcategory-filter__tabs').show();
				$('.subcategory-filter__reset').show();
			}

		})
	}

	function check_product_count() {
		var filter = $('#filter');
		var formData = '';
		var currentParam = '';
		var notFirstParam = false;
		var formDataSource = filter.serializeArray();
		$.each(formDataSource, function (i, formDataSource) {
			if (currentParam == formDataSource.name) {
				formData += ',' + formDataSource.value
			} else {
				currentParam = formDataSource.name;
				if (notFirstParam) {
					formData += '&';
				}
				formData += currentParam + '=' + formDataSource.value;
				notFirstParam = true;
			}
		});

		// Если в пути есть /page/2/ и далее — удаляем ее
		var pathnameWoPages = window.location.pathname.replace(/\/page\/\d+\//g, '');


		// Получаем текущий URL без параметров
		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host + pathnameWoPages;

		// Добавляем к нему параметры калькулятора
		let newUrl = baseUrl + "?" + formData + "#content";
		$.ajax({
			url: filter.attr('action'),
			data: formData, // form data
			type: filter.attr('method'), // POST
			beforeSend: function (xhr) {
				// console.log('Processing...'); // changing the button label
			},
			success: function (data) {


				// Убираем все плашки
				iziToast.destroy();
				// Показываем плашку с найденными товарами
				iziToast.show({
					color: '#7ed57b',
					icon: 'fas fa-search',
					title: '<a href="' + newUrl + '">Подобрано: ' + data + '</a>',
					target: '.filter-notification',
					targetFirst: true,
					progressBar: false,
					timeout: false,
					balloon: true,
					displayMode: 2,
					animateInside: false,
				});

			}
		});

	}

	// При нажатии на каждый элемент фильтра...
	$('.subcategory-filter__tab-param input:checkbox').click(function () {

		var currentParam = $(this).closest(".subcategory-filter__tab-param");
		var pos = currentParam.position();
		var width = currentParam.outerWidth();
		var height = currentParam.outerHeight();

		// ... для ПК, позиционируем плашку с найденными товарами напротив конкретного фильтра
		if ($(document).width() >= 992) {
			$('.filter-notification__wrap').css({
				top: (pos.top - 20) + "px",
				left: (pos.left + width + 15) + "px"
			})
		}

		// ajax запрос количества товаров
		check_product_count();

	});

	// Smooth scrolling anchor links
	function ea_scroll(hash) {
		var target = $(hash);
		target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
		if (target.length) {
			var top_offset = 0;
			console.log($('.top-line').css('position'));
			if ($('.top-line').css('position') == 'fixed') {

				top_offset = $('.top-line').height();
			}
			if ($('body').hasClass('admin-bar')) {
				top_offset = top_offset + $('#wpadminbar').height();
			}
			$('html,body').animate({
				scrollTop: target.offset().top - top_offset
			}, 1000);
			return false;
		}
	}
	// -- Smooth scroll on pageload
	if (window.location.hash) {
		ea_scroll(window.location.hash);
	}
	// -- Smooth scroll on click
	$('a[href*="#"]:not([href="#"]):not(.no-scroll)').click(function () {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') || location.hostname == this.hostname) {
			ea_scroll(this.hash);
		}
	});
});
