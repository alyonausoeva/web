jQuery(function($){

    // обрабатываем нажатие кнопки «Просмотр товара»
    $(document).on('click', '.read-one-product-button', function(){
        // get product id
        var certificate_id = $(this).attr('data-certificate_id');
        // чтение записи товара на основе данного идентификатора
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/certificate/read_one.php?certificate_id=" + certificate_id, function(data){
            // начало html
            var read_one_product_html=`
    
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>
    <!-- полные данные о товаре будут показаны в этой таблице -->
<table class='table table-bordered table-hover'>

    <tr>
        <td class='w-30-pct'>id свидетельства</td>
        <td class='w-70-pct'>` + data.certificate_id + `</td>
    </tr>

    <tr>
        <td>Дата выдачи</td>
        <td>` + data.certificate_date + `</td>
    </tr>

    <tr>
        <td>id заявки </td>
        <td>` + data.contract_id + `</td>
    </tr>

    <tr>
        <td>id квитанции об оплате  </td>
        <td>` + data.pay_id + `</td>
    </tr>
	
	

</table>`;
// вставка html в «page-content» нашего приложения 
$("#page-content").html(read_one_product_html);

// изменяем заголовок страницы 
changePageTitle("Информация о свидетельстве");
        });
    });

});