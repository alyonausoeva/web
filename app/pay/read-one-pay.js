jQuery(function($){

    // обрабатываем нажатие кнопки «Просмотр товара»
    $(document).on('click', '.read-one-product-button', function(){
        // get product id
        var pay_id = $(this).attr('data-pay_id');
        // чтение записи товара на основе данного идентификатора
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/pay/read_one.php?pay_id=" + pay_id, function(data){
            // начало html
            var read_one_product_html=`
    
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>
    <!-- полные данные о товаре будут показаны в этой таблице -->
<table class='table table-bordered table-hover'>

    <tr>
        <td class='w-30-pct'>id квитанции об оплате</td>
        <td class='w-70-pct'>` + data.pay_id + `</td>
    </tr>

    <tr>
        <td>Сумма оплаты</td>
        <td>` + data.pay_sum + `</td>
    </tr>

    

    <tr>
        <td>Дата совершения оплаты  </td>
        <td>` + data.pay_date + `</td>
    </tr>
	
	

</table>`;
// вставка html в «page-content» нашего приложения 
$("#page-content").html(read_one_product_html);

// изменяем заголовок страницы 
changePageTitle("Информация о квитанции оплаты");
        });
    });

});