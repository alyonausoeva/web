jQuery(function($){

    // обрабатываем нажатие кнопки «Просмотр товара»
    $(document).on('click', '.read-one-product-button', function(){
        // get product id
        var klient_id = $(this).attr('data-klient_id');
        // чтение записи товара на основе данного идентификатора
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/klient/read_one.php?klient_id=" + klient_id, function(data){
            // начало html
            var read_one_product_html=`
    
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>
    <!-- полные данные о товаре будут показаны в этой таблице -->
<table class='table table-bordered table-hover'>

    <tr>
        <td class='w-30-pct'>id клиента</td>
        <td class='w-70-pct'>` + data.klient_id + `</td>
    </tr>

    <tr>
        <td>ФИО</td>
        <td>` + data.klient_fio + `</td>
    </tr>

    

    <tr>
        <td>Паспортные данные </td>
        <td>` + data.klient_pas + `</td>
    </tr>
	<tr>
        <td>Номер телефона </td>
        <td>` + data.klient_tel + `</td>
    </tr>
	
	<tr>
        <td>Адрес электронной почты </td>
        <td>` + data.klient_email + `</td>
    </tr>
	
	

</table>`;
// вставка html в «page-content» нашего приложения 
$("#page-content").html(read_one_product_html);

// изменяем заголовок страницы 
changePageTitle("Информация о клиенте");
        });
    });

});jQuery(function($){

    // показать список товаров при первой загрузке
    showProductsFirstPage();

    // когда была нажата кнопка «Все товары»
    $(document).on('click', '.read-products-button', function(){
        showProductsFirstPage();
    });

    // когда была нажата кнопка «страница»
    $(document).on('click', '.pagination li', function(){
        // получаем json url
        var json_url=$(this).find('a').attr('data-page');

        // покажем список товаров
        showProducts(json_url);
    });

});

function showProductsFirstPage(){
    var json_url="http://web.std-237.ist.mospolytech.ru/api/klient/read_paging.php";
    showProducts(json_url);
}

// функция для отображения списка товаров
function showProducts(json_url){

    // получаем список товаров из API
    $.getJSON(json_url, function(data){

        // HTML для перечисления товаров
        readProductsTemplate(data, "");

        // изменим заголовок страницы
        changePageTitle("Все записи");

    });
}