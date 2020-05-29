jQuery(function($){

    // обрабатываем нажатие кнопки «Просмотр товара»
    $(document).on('click', '.read-one-product-button', function(){
        // get product id
        var officer_id = $(this).attr('data-officer_id');
        // чтение записи товара на основе данного идентификатора
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/officer/read_one.php?officer_id=" + officer_id, function(data){
            // начало html
            var read_one_product_html=`
    
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>
    <!-- полные данные о товаре будут показаны в этой таблице -->
<table class='table table-bordered table-hover'>

    <tr>
        <td class='w-30-pct'>id сотрудника</td>
        <td class='w-70-pct'>` + data.officer_id + `</td>
    </tr>

    <tr>
        <td>ФИО</td>
        <td>` + data.officer_name + `</td>
    </tr>

    <tr>
        <td>id отдела</td>
        <td>` + data.department_id + `</td>
    </tr>

    <tr>
        <td>Паспортные данные </td>
        <td>` + data.officer_pas + `</td>
    </tr>
	
	<tr>
        <td>Дата приема на работу</td>
        <td>` + data.officer_date + `</td>
    </tr>
	
	<tr>
        <td>Уровень доступа</td>
        <td>` + data.officer_level + `</td>
    </tr>

</table>`;
// вставка html в «page-content» нашего приложения 
$("#page-content").html(read_one_product_html);

// изменяем заголовок страницы 
changePageTitle("Информация о сотруднике");
        });
    });

});