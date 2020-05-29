jQuery(function($){

    // когда была нажата кнопка «Поиск товаров»
    $(document).on('submit', '#search-product-form', function(){

        // получаем ключевые слова для поиска
        var keywords = $(this).find(":input[name='keywords']").val();

        // получаем данные из API на основе поисковых ключевых слов
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/certificate/search.php?s=" + keywords, function(data){

            // шаблон в products.js
            readProductsTemplate(data, keywords);

            // изменяем title
            changePageTitle("Поиск по записям: " + keywords);

        });

        // предотвращаем перезагрузку всей страницы
        return false;
    });

});