jQuery(function($){

    // когда была нажата кнопка «Поиск товаров»
    $(document).on('submit', '#filtr-product-form', function(){

        // получаем ключевые слова для поиска
        var keywords = $(this).find(":input[name='keywords']").val();

        // получаем данные из API на основе поисковых ключевых слов
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/pay/filtr.php?s=" + keywords, function(data){

            // шаблон в products.js
            readProductsTemplate(data, keywords);

            // изменяем title
            changePageTitle("Сумма оплаты до: " + keywords);

        });

        // предотвращаем перезагрузку всей страницы
        return false;
    });

});