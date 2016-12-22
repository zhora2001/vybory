function ajax_go(data, jqForm, options) { //ф-я перед отправкой запроса
    jQuery('#output').html('Відправляємо...'); // в див для ответа напишем "отправляем.."
   jQuery('#sub').attr("disabled", "disabled"); // кнопку выключим
}

function response_go_ch(out) {
    //  jQuery(this).html(out.data.ID);
    //      jQuery('#output').html(out.data.ID);
    //        jQuery('#output').text(out.data.ID);
    console.log(out);
    jQuery('#input_prihil').show('slow');
    jQuery('#ufamily').val(out.data.ufamily);
    jQuery('#uname').val(out.data.uname);
    jQuery('#ubatk').val(out.data.ubatk);
    jQuery('#uname').val(out.data.uname);
    jQuery('#tel_o').val(out.data.tel_o); // заполняем произвольное поле типа строка
    jQuery('#tel_dod').val(out.data.tel_dod); // заполняем произвольное поле типа строка
    jQuery('#sotc_merega').val(out.data.sotc_merega); // заполняем произвольное поле типа строка
    jQuery('#adressa').val(out.data.adressa); // заполняем произвольное поле типа строка
    jQuery('#beathday').val(out.data.beathday); // заполняем произвольное поле типа строка
    jQuery('#id_kod').val(out.data.id_kod); // заполняем произвольное поле типа строка
    jQuery('#likar').val(out.data.likar);
    jQuery('#deputat').val(out.data.deputat);
    jQuery('#derzh_sl').val(out.data.derzh_sl);
    jQuery('#bezrob').val(out.data.bezrob);
    jQuery('#pensioner').val(out.data.pensioner);
    jQuery('#ato').val(out.data.ato);
    jQuery('#invalid').val(out.data.invalid);
    jQuery('#autoritet').val(out.data.autoritet);
    jQuery('#uchitel').val(out.data.uchitel);
    jQuery('#pidpr').val(out.data.pidpr);
    jQuery('#n_prih').attr('value', out.data.id);
    //        jQuery("#content").animate({scrollTop:0},"slow");
    jQuery(document).scrollTop();
    jQuery('html, body').animate({
        scrollTop: 0
    }, 500);

}

function req_come(out) { // ф-я обработки ответа от wp, в out будет элемент success(bool), который зависит от ф-и вывода которую мы использовали в обработке(wp_send_json_error() или wp_send_json_success()), и элемент data в котором будет все что мы передали аргументом к ф-и wp_send_json_success() или wp_send_json_error()
    console.log(out); // для дебага
    jQuery('#sub').prop("disabled", false); // кнопку включим
    var t=out.data.message;
    jQuery('#output').html(t); // выведем результат
//    jQuery("form")[0].reset();и передан redirect, делаем перенаправление
    		ajaxgo = false; // аякс запрос выполнен можно выполнять следующий
    }


jQuery(document).ready(function() {
   jQuery('#primary-menu').append("<li class='menu-item site-navigation' style='color:white;'> Ви війшли як "+
   jQuery('#login_cur_user').text() +"  </li>");
    jQuery("#spys_diln").change(function() {
            jQuery('#n_diln').attr('value',jQuery(this).val());
            jQuery('#nazva_d').attr("value",jQuery('#spys_diln option[value = '+jQuery('#spys_diln').val()+']').text());
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

    add_form = jQuery('#add_object'); // запишем форму в переменную
    var options = { // опции для отправки формы с помощью jquery form
        data: { // дополнительные параметры для отправки вместе с данными формы
            action: 'reg_problema', // этот параметр будет указывать wp какой экшн запустить, у нас это wp_ajax_nopriv_add_object_ajax
            nonce: reg_problema.nonce // строка для проверки, что форма отправлена откуда надо
        },
        dataType: 'json', // ответ ждем в json формате
        beforeSubmit: ajax_go, // перед отправкой вызовем функцию ajax_go()
        success: req_come, // после получении ответа вызовем response_go()
        error: function(request, status, error) { // в случае ошибки
            console.log(arguments); // напишем все в консоль
        },
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
        console.log(a2);
        jQuery.ajax({
            url: ajaxchange.url,
            data: { // дополнительные параметры для отправки вместе с данными формы
                action: 'change_object_ajax', // этот параметр будет указывать wp какой экшн запустить, у нас это wp_ajax_nopriv_add_object_ajax
                nonce: reg_problema.wnonce, // строка для проверки, что форма отправлена откуда надо
                //id_p: a2.text(),
            },
            dataType: 'json',
            success: response_go_ch,
            //  jQuery(this).before("<input type='file' name='passport[]' />"); // добавим перед ссылкой еще один инпут типа файл с таким же нэймом
        });

    });
});
