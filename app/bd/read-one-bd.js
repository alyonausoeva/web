jQuery(function($){

    // обрабатываем нажатие кнопки «Просмотр товара»
    $(document).on('click', '.read-one-product-button', function(){
        // get product id
        var bd_id = $(this).attr('data-bd_id');
        // чтение записи товара на основе данного идентификатора
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/bd/read_one.php?bd_id=" + bd_id, function(data){
            // начало html
            var read_one_product_html=`
    
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>
    <!-- полные данные о товаре будут показаны в этой таблице -->
<table class='table table-bordered table-hover'>

    <tr>
        <td class='w-30-pct'>id базы данных</td>
        <td class='w-70-pct'>` + data.bd_id + `</td>
    </tr>

    <tr>
        <td>Название базы данных</td>
        <td>` + data.bd_name + `</td>
    </tr>

    <tr>
        <td>Область применения </td>
        <td>` + data.bd_application + `</td>
    </tr>

    <tr>
        <td>Объем  </td>
        <td>` + data.bd_volume + `</td>
    </tr>
	
	

</table>`;
// вставка html в «page-content» нашего приложения 
$("#page-content").html(read_one_product_html);

// изменяем заголовок страницы 
changePageTitle("Информация о сотруднике");
        });
    });

});