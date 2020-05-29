jQuery(function($){

    // показывать html форму при нажатии кнопки «Обновить товар»
    $(document).on('click', '.update-product-button', function(){

        // получаем ID товара
        var pay_id = $(this).attr('data-pay_id');
        // читаем одну запись на основе данного идентификатора товара
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/pay/read_one.php?pay_id=" + pay_id, function(data){

            // значения будут использоваться для заполнения нашей формы
            var pay_id = data.pay_id;
			var pay_sum = data.pay_sum;
            
			
            var pay_date = data.pay_date;
            
           

            // загрузка списка категорий
            $.getJSON("http://web.std-237.ist.mospolytech.ru/api/pay/read.php", function(data){

              

                // сохраним html в переменной «update product»
                var update_product_html=`
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>

    <!-- построение формы для изменения товара -->
    <!-- мы используем свойство 'required' html5 для предотвращения пустых полей -->
    <form id='update-product-form' action='#' method='post' border='0'class=' form_auth form light_blue'>
                 
		
		<div class="form__label"> id квитанции об оплате</div>
		<div>
		<input value="` + pay_id + `"  name='pay_id' class='form__input input form-control' required />
        </div>


        <div class="form__label"> Сумма оплаты</div>
		<div><input  value="` + pay_sum + `" name='pay_sum' class='form__input input form-control' required /></div>

        
		
		<div class="form__label"> Дата совершения оплаты </div>
		 <div><input value="` + pay_date + `"  name='pay_date' class='form__input input form-control' required /></div>
		

		
		          

            

                 <div class="form__submit ">
                    <button type='submit' class='btn btn-primary blue input form__button''>
                        Обновить 
                    </button>
                </div>

        </table>
    </form>
`;

// добавим в «page-content» нашего приложения
                $("#page-content").html(update_product_html);

// изменим title страницы
                changePageTitle("Обновление записи");
            });
        });
    });

    // будет запущен при отправке формы обновления товара
    $(document).on('submit', '#update-product-form', function(){

        // получаем данные формы
        var form_data=JSON.stringify($(this).serializeObject());

        // отправка данных формы в API
        $.ajax({
            url: "http://web.std-237.ist.mospolytech.ru/api/pay/update.php",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {
                // продукт был создан, возврат к списку продуктов
                showProducts();
            },
            error: function(xhr, resp, text) {
                // вывод ошибки в консоль
                console.log(xhr, resp, text);
            }
        });

        return false;
    });
});