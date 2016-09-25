function ajax_go(data, jqForm, options) { //ф-я перед отправкой запроса
    jQuery('#output').html('Відправляємо...'); // в див для ответа напишем "отправляем.."
    jQuery('#sub').attr("disabled", "disabled"); // кнопку выключим
}

function ajax_go_ch() { //ф-я перед отправкой запроса
    jQuery('#output').html('Завантажуємо данні з сервера...'); // в див для ответа напишем "отправляем.."

}


function get_err(out) { // в случае ошибки
    //console.log(arguments);
    jQuery('#output').text(out.data.message);
    jQuery('#n_prih').attr('value','-1');
}

function response_go_ch(out) {
    //  jQuery(this).html(out.data.ID);
    //      jQuery('#output').html(out.data.ID);
    //        jQuery('#output').text(out.data.ID);
    console.log(out);
    jQuery('#input_prihil').show('slow');
    jQuery('#n_prih').attr('value',(out.data.ID));
    if (!out.data.ID)
    jQuery('#n_prih').attr('value','-1');
    jQuery('#adressa').val(out.data.adresa); // заполняем произвольное поле типа строка
    jQuery('#mezhi').val(out.data.mezhi); // заполняем произвольное поле типа строка
    jQuery('#pidpryems').val(out.data.pidpryems); // заполняем произвольное поле типа строка
    jQuery('#spysok_boss').val(out.data.spysok_boss); // заполняем произвольное поле типа строка
    jQuery('#ustanovy').val(out.data.ustanovy); // заполняем произвольное поле типа строка

//    jQuery('#ksch').val(out.data.vyd); // заполняем произвольное поле типа строка
    jQuery('#misce_zustr').val(out.data.misce_zustr); // заполняем произвольное поле типа строка
    jQuery('#output').text('');


    jQuery('#vv1 option[value="'+ out.data.vyd +'"]').prop('selected', true);
    jQuery('#nazva_d').attr("value",jQuery('#spys_diln option[value = '+jQuery('#spys_diln').val()+']').text());
    //jQuery('#nazva').val(jQuery('#spys_diln option[value = '+jQuery('#spys_diln').val()+']').text());
    //        jQuery("#content").animate({scrollTop:0},"slow");
    //jQuery(document).scrollTop();
    jQuery('html, body').animate({
        scrollTop: 0
    }, 500);

}

function response_go(out) { // ф-я обработки ответа от wp, в out будет элемент success(bool), который зависит от ф-и вывода которую мы использовали в обработке(wp_send_json_error() или wp_send_json_success()), и элемент data в котором будет все что мы передали аргументом к ф-и wp_send_json_success() или wp_send_json_error()
    console.log(out); // для дебага
    jQuery('#sub').prop("disabled", false); // кнопку включим
    jQuery('#output').html(out.data); // выведем результат
    //setTimeout(function() {
    //    if (data.data.redirect) window.location.href = data.data.redirect;
    // Ваш скрипт
    //}, 3000);
    //jQuery("form")[0].reset();;
    jQuery('#n_prih').attr('value','-1');
    jQuery('#adressa').val(''); // заполняем произвольное поле типа строка
    jQuery('#mezhi').val(''); // заполняем произвольное поле типа строка
    jQuery('#pidpryems').val(''); // заполняем произвольное поле типа строка
    jQuery('#spysok_boss').val(''); // заполняем произвольное поле типа строка
    jQuery('#ustanovy').val(''); // заполняем произвольное поле типа строка

//    jQuery('#ksch').val(out.data.vyd); // заполняем произвольное поле типа строка
    jQuery('#misce_zustr').val(''); // заполняем произвольное поле типа строка

}

jQuery(document).ready(function() {

    jQuery('#primary-menu').append("<li class='menu-item site-navigation' style='color:white;'> Ви війшли як "+
    jQuery('#login_cur_user').text() +"  </li>");

    jQuery("#spys_diln").change(function() {
        jQuery("#n_diln").attr('value',jQuery(this).val());

        var a1 = jQuery(this).val();
        //console.log(a2);
        ajax_go_ch();
        jQuery.ajax({
            url: ajaxdata.url,
            data: { // дополнительные параметры для отправки вместе с данными формы
                action: 'change_passport_dvk', // этот параметр будет указывать wp какой экшн запустить, у нас это wp_ajax_nopriv_add_object_ajax
                nonce: ajaxpassport.cnonce, // строка для проверки, что форма отправлена откуда надо
                id_p: a1,
            },
            dataType: 'json',
            success: response_go_ch,
            error: get_err
            //  jQuery(this).before("<input type='file' name='passport[]' />"); // добавим перед ссылкой еще один инпут типа файл с таким же нэймом
        });

        });

    jQuery("#n_diln").attr('value',jQuery("#spys_diln").val());

    jQuery(".prihil_nyk").mouseover(function() {
        jQuery(this).find(".change_prihil").show();
        jQuery(this).find(".view_prihil").show();
    });
    jQuery(".prihil_nyk").mouseout(function() {
        jQuery(this).find(".change_prihil").hide();
        jQuery(this).find(".view_prihil").hide();
    });
    jQuery(".various").fancybox({
        maxWidth: 800,
        maxHeight: 600,
        fitToView: false,
        //  		width		: '70%',
        //  		height		: '70%',
        autoSize: true,
        closeClick: true,
        openEffect: 'none',
        closeEffect: 'none'
    });

    jQuery(".view_prihil").fancybox({
        maxWidth: 800,
        maxHeight: 600,
        fitToView: false,
        //  		width		: '70%',
        //  		height		: '70%',
        autoSize: true,
        closeClick: true,
        openEffect: 'none',
        closeEffect: 'none'
    });


    jQuery('a.iframe').fancybox();
    jQuery('#input_prihil').hide();
    jQuery(function(u) {
        jQuery("#beathday").mask("99/99/9999", {
            placeholder: "дд.мм.рррр"
        });
        jQuery("#tel_o").mask("(999) 999-9999");
        jQuery("#tel_dod").mask("(999) 999-9999");
    });
    // после загрузки страницы

    add_form = jQuery('#add_passport'); // запишем форму в переменную
    var options = { // опции для отправки формы с помощью jquery form
        data: { // дополнительные параметры для отправки вместе с данными формы
            action: 'add_passport',
            nonce: ajaxpassport.nonce,
            nazva: jQuery('#spys_diln').text() // строка для проверки, что форма отправлена откуда надо
        },
        dataType: 'json', // ответ ждем в json формате
        beforeSubmit: ajax_go, // перед отправкой вызовем функцию ajax_go()
        success: response_go, // после получении ответа вызовем response_go()
        error:get_err,
        url: ajaxdata.url // куда слать форму, переменную с url мы определили вывели в нулевом шаге
    };

    add_form.ajaxForm(options); // подрубаем плагин jquery form с опциями на нашу форму

    jQuery('#pass').click(function(gg) { // по клику на ссылку "Добавить еще фото"
        gg.preventDefault(); // выключим стандартное поведение ссылки
        jQuery(this).before("<input type='file' name='passport[]' />"); // добавим перед ссылкой еще один инпут типа файл с таким же нэймом
    });

    jQuery('#dod_declar').click(function(ff) { // по клику на ссылку "Добавить еще фото"
        ff.preventDefault(); // выключим стандартное поведение ссылки
        jQuery(this).before("<input type='file' name='declar[]' />"); // добавим перед ссылкой еще один инпут типа файл с таким же нэймом
    });

    jQuery('#btn_prihil').on('click', (function(ffа) { // по клику на ссылку "Добавить еще фото"
        if (jQuery('#input_prihil').is(':hidden')) {
            jQuery('#input_prihil').show('slow');
            jQuery('#btn_prihil').text("Закрити форму");
        } else {
            jQuery('#input_prihil').hide('slow');
            jQuery('#btn_prihil').text("Відкрити форму");
        }

        //Зміна данних прихільника
    }));


    jQuery(".change_prihil").click(function(ggg) { // по клику на ссылку "Добавить еще фото"
        ggg.preventDefault(); // выключим стандартное поведение ссылки
        var a1 = jQuery(this);
        var a2 = a1.closest('.prihil_nyk').find('.id_p');
        var a3 = a1.closest('.prihil_nyk').find('.n_diln');
        if (a3.val() > -4)
        {
        console.log(a2);
        jQuery.ajax({
            url: ajaxchange.url,
            data: { // дополнительные параметры для отправки вместе с данными формы
                action: 'change_passport_dvk', // этот параметр будет указывать wp какой экшн запустить, у нас это wp_ajax_nopriv_add_object_ajax
                nonce: ajaxchangepassport.cnonce, // строка для проверки, что форма отправлена откуда надо
                id_p: a2.text(),
            },
            dataType: 'json',
            success: response_go_ch,
            error: get_err,
            //  jQuery(this).before("<input type='file' name='passport[]' />"); // добавим перед ссылкой еще один инпут типа файл с таким же нэймом
                }
        );
    }
    });

});
