jQuery(function($){

    // обрабатываем нажатие кнопки «Просмотр товара»
    $(document).on('click', '.read-one-product-button', function(){
        // get product id
        var contract_id = $(this).attr('data-contract_id');
        // чтение записи товара на основе данного идентификатора
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/contract/read_one.php?contract_id=" + contract_id, function(data){
            // начало html
            var read_one_product_html=`
    
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>
    <!-- полные данные о товаре будут показаны в этой таблице -->
<table class='table table-bordered table-hover'>

    <tr>
        <td class='w-30-pct'>id регистрационной заявки</td>
        <td class='w-70-pct'>` + data.contract_id + `</td>
    </tr>

    <tr>
        <td>id клиента</td>
        <td>` + data.klient_id + `</td>
    </tr>

    <tr>
        <td>id регистрируемой базы данных</td>
        <td>` + data.bd_id + `</td>
    </tr>

    <tr>
        <td>Дата создания заявки </td>
        <td>` + data.contract_date + `</td>
    </tr>
	
	<tr>
        <td>Статус заявки</td>
        <td>` + data.contract_status + `</td>
    </tr>
	
	<tr>
        <td>id сотрудника</td>
        <td>` + data.officer_id + `</td>
    </tr>

</table>`;
// вставка html в «page-content» нашего приложения 
$("#page-content").html(read_one_product_html);

// изменяем заголовок страницы 
changePageTitle("Информация о регистрационной заявке");
        });
    });

});