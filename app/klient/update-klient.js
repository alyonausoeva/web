jQuery(function($){

    // показывать html форму при нажатии кнопки «Обновить товар»
    $(document).on('click', '.update-product-button', function(){

        // получаем ID товара
        var klient_id = $(this).attr('data-klient_id');
        // читаем одну запись на основе данного идентификатора товара
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/klient/read_one.php?klient_id=" + klient_id, function(data){

            // значения будут использоваться для заполнения нашей формы
            var klient_id = data.klient_id;
			var klient_fio = data.klient_fio;
            var klient_pas = data.klient_pas;
			
            var klient_tel = data.klient_tel;
            var klient_email = data.klient_email;
            

            // загрузка списка категорий
            $.getJSON("http://web.std-237.ist.mospolytech.ru/api/klient/read.php", function(data){

              

                // сохраним html в переменной «update product»
                var update_product_html=`
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>

    <!-- построение формы для изменения товара -->
    <!-- мы используем свойство 'required' html5 для предотвращения пустых полей -->
    <form id='update-product-form' action='#' method='post' border='0'class=' form_auth form light_blue'>
                 
		
		<div class="form__label"> id клиента</div>
		<div>
		<input value="` + klient_id + `"  name='klient_id' class='form__input input form-control' required />
        </div>


        <div class="form__label"> ФИО</div>
		<div><input  value="` + klient_fio + `" name='klient_fio' class='form__input input form-control' required /></div>

        <div class="form__label"> Паспортные данные</div>
		<div><input value="` + klient_pas + `"  name='klient_pas' class='form__input input form-control' required /></div>
		
		<div class="form__label"> Телефон</div>
		 <div><input value="` + klient_tel + `"  name='klient_tel' class='form__input input form-control' required /></div>
		
<div class="form__label"> Адрес электонной почты</div>
		 <div><input value="` + klient_email + `"  name='klient_email' class='form__input input form-control' required /></div>


		
		          

            

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
            url: "http://web.std-237.ist.mospolytech.ru/api/klient/update.php",
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