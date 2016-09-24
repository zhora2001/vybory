var ajaxgo = false; // глобальная переменная, чтобы проверять обрабатывается ли в данный момент другой запрос

function req_go(data, form, options) { // ф-я срабатывающая перед отправкой
		if (ajaxgo) { // если какой либо запрос уже был отправлен
				form.find('.response').html('<p class="error">Необхідно дочекатись відоповіді від попереднього запита.</p>'); // в див для ответов напишем ошибку
				return false; // и ничего не будет делать
		}
		form.find('input[type="submit"]').attr('disabled', 'disabled').val('Чекаємо..'); // выключаем кнопку и пишем чтоб подождали
		form.find('.response').html(''); // опусташаем див с ответом
		ajaxgo = true; // записываем в переменную что аякс запрос ушел
}

function req_come(data, statusText, xhr, form) { // ф-я срабатывающая после того как пришел ответ от сервера, внутри data будет json объект с ответом
		console.log(arguments); // это для дебага
		if (data.success) { // если все хорошо и ошибок нет
				var response = '<p class="success">' + data.data.message + '</p>'; // пишем ответ в <p> с классом success
				form.find('input[type="submit"]').val('Готово'); // в кнопку напишем Готово
		} else { // если есть ошибка
				var response = '<p class="error">' + data.data.message + '</p>'; // пишем ответ в <p> с классом error
				form.find('input[type="submit"]').prop('disabled', false).val('Отправить'); // снова включим кнопку
		}
		form.find('.response').html(response); // выводим ответ
		ajaxgo = false; // аякс запрос выполнен можно выполнять следующий
        setTimeout(function() {
            // Ваш скрипт
        }, 3000);
        if (data.data.redirect) window.location.href = data.data.redirect;
         // если передан redirect, делаем перенаправление

}



jQuery(document).ready(function() { // после загрузки DOM
    jQuery('#primary-menu').append("<li class='menu-item site-navigation' style='color:white;'> Ви війшли як "+
    jQuery('#login_cur_user').text() +"  </li>");

    jQuery('#r_diln').attr('checked', true);
    jQuery('#r_kusch').attr('checked', false);
    jQuery('#vv').show();
    jQuery('#vv1').hide();

    jQuery("#tel").mask("(999) 999-9999");

    jQuery('#r_kusch').on('change', function() {
        jQuery('#r_diln').attr('checked', false);
        jQuery('#vv1').show();
        jQuery('#vv').hide();
    });

    jQuery('#r_diln').on('change', function() {
        jQuery('#r_kusch').attr('checked', false);
        jQuery('#vv').show();
        jQuery('#vv1').hide();
    });


     var options = { // опции для отправки формы с помощью jquery form
        data: { // дополнительные параметры для отправки вместе с данными формы
            action: 'new_user', // этот параметр будет указывать wp какой экшн запустить, у нас это wp_ajax_nopriv_add_object_ajax
            wnonce: reg_nuser.wnonce, // строка для проверки, что форма отправлена откуда надо
            dl_chk: jQuery('#r_diln').attr('checked'),
            ks_chk: jQuery('#r_kusch').attr('checked'),
                },
        dataType: 'json', // ответ ждем в json формате
        beforeSubmit: req_go, // перед отправкой вызовем функцию ajax_go()
        success: req_come, // после получения ответа вызовем response_go()

        error: function(request, status, error) { // в случае ошибки
            console.log(arguments); // напишем все в консоль
        },
        url: ajaxdata.url // куда слать форму, переменную с url мы определили вывели в нулевом шаге
    };

		var userform = jQuery('#new_user_form'); // пишем в переменную все формы с классом userform
		userform.ajaxForm(options); // подрубаем плагин jquery form с опциями на нашу форму


});
