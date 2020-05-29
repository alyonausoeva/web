jQuery(function($){

    // обрабатываем нажатие кнопки «Просмотр товара»
    $(document).on('click', '.read-one-product-button', function(){
        // get product id
        var department_id = $(this).attr('data-department_id');
        // чтение записи товара на основе данного идентификатора
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/department/read_one.php?department_id=" + department_id, function(data){
            // начало html
            var read_one_product_html=`
    
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>
    <!-- полные данные о товаре будут показаны в этой таблице -->
<table class='table table-bordered table-hover'>

    <tr>
        <td class='w-30-pct'>id отдела</td>
        <td class='w-70-pct'>` + data.department_id + `</td>
    </tr>

    <tr>
        <td>Название отдела</td>
        <td>` + data.department_name + `</td>
    </tr>

    

    <tr>
        <td>Количество сотрудников  </td>
        <td>` + data.department_officers + `</td>
    </tr>
	
	

</table>`;
// вставка html в «page-content» нашего приложения 
$("#page-content").html(read_one_product_html);

// изменяем заголовок страницы 
changePageTitle("Информация об отделе");
        });
    });

});