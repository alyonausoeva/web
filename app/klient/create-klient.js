jQuery(function ($) {

    // показать html форму при нажатии кнопки «создать товар»
    $(document).on('click', '.create-product-button', function () {
        // загрузка списка категорий
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/klient/read.php", function (data) {
            // перебор возвращаемого списка данных и создание списка выбора
            var categories_options_html = `<select fio='category_id' class='form-control'>`;
            $.each(data.records, function (key, val) {
                categories_options_html += `<option value='` + val.id + `'>` + val.fio + `</option>`;
            });
            categories_options_html += `</select>`;
            var create_product_html = `
    <!-- кнопка для показа всех товаров -->
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>
	
    
<form id='create-product-form' action='#' method='post' border='0' class=' form_auth form light_blue'>

    

        <div class="form__label"> id клиента</div>
		<div>
           <input  fio='klient_id' class='form__input input form-control ' required />
        </div>

        <div class="form__label"> ФИО</div>
		<div>
        <input fio='klient_fio' class='input form-control' required />
      </div>

        <div class="form__label"> Паспортные данные</div>
		<div>
         <input fio='klient_tel' class='input form-control' required>
		 </div>
        
		
		 <div class="form__label"> Телефон</div>
		 <div>
         <input fio='klient_tel' class='input form-control' required>
		 </div>
        
		
		 <div class="form__label"> Адрес электонной почты</div>
		 <div>
            <input fio='klient_email' class='input form-control' required>
			</div>
       
		
		 <div class="form__label"> Уровень доступа</div>
		 <div>
         <input fio='klient_level' class='input form-control' required>
        </div>

        <!-- кнопка отправки формы -->
       <div class="form__submit ">
                <button type='submit' class='btn btn-primary blue input form__button'>
                     Создать 
                </button>
             </div>
</form>`;
            // вставка html в «page-content» нашего приложения
            $("#page-content").html(create_product_html);

// изменяем тайтл
            changePageTitle("Создание записи");

        });
        
    });

    // будет работать, если создана форма товара
    $(document).on('submit', '#create-product-form', function(){
        // получение данных формы
        var form_data=JSON.stringify($(this).serializeObject());

        // отправка данных формы в API
        $.ajax({
            url: "http://web.std-237.ist.mospolytech.ru/api/klient/create.php",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {
                // продукт был создан, вернуться к списку продуктов
                showProducts();
            },
            error: function(xhr, resp, text) {
                // вывести ошибку в консоль
                console.log(xhr, resp, text);
            }
        });

        return false;
    });
});