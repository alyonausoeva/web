jQuery(function($){

    // показывать html форму при нажатии кнопки «Обновить товар»
    $(document).on('click', '.update-product-button', function(){

        // получаем ID товара
        var certificate_id = $(this).attr('data-certificate_id');
        // читаем одну запись на основе данного идентификатора товара
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/certificate/read_one.php?certificate_id=" + certificate_id, function(data){

            // значения будут использоваться для заполнения нашей формы
            var certificate_id = data.certificate_id;
			var certificate_date = data.certificate_date;
            var contract_id = data.contract_id;
			
            var pay_id = data.pay_id;
          

            // загрузка списка категорий
            $.getJSON("http://web.std-237.ist.mospolytech.ru/api/certificate/read.php", function(data){

              

                // сохраним html в переменной «update product»
                var update_product_html=`
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>

    <!-- построение формы для изменения товара -->
    <!-- мы используем свойство 'required' html5 для предотвращения пустых полей -->
    <form id='update-product-form' action='#' method='post' border='0'class=' form_auth form light_blue'>
                 
		
		<div class="form__label"> id свидетельства</div>
		<div>
		<input value="` + certificate_id + `"  name='certificate_id' class='form__input input form-control' required />
        </div>


        <div class="form__label"> Дата выдачи</div>
		<div><input  value="` + certificate_date + `" name='certificate_date' class='form__input input form-control' required /></div>

        <div class="form__label"> id заявки </div>
		<div><input value="` + contract_id + `"  name='contract_id' class='form__input input form-control' required /></div>
		
		<div class="form__label"> id квитанции об оплате </div>
		 <div><input value="` + pay_id + `"  name='pay_id' class='form__input input form-control' required /></div>
		

		
		          

            

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
            url: "http://web.std-237.ist.mospolytech.ru/api/certificate/update.php",
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