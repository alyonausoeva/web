jQuery(function($){

    // показывать html форму при нажатии кнопки «Обновить товар»
    $(document).on('click', '.update-product-button', function(){

        // получаем ID товара
        var bd_id = $(this).attr('data-bd_id');
        // читаем одну запись на основе данного идентификатора товара
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/bd/read_one.php?bd_id=" + bd_id, function(data){

            // значения будут использоваться для заполнения нашей формы
            var bd_id = data.bd_id;
			var bd_name = data.bd_name;
            var bd_application = data.bd_application;
			
            var bd_volume = data.bd_volume;
            var bd_date = data.bd_date;
            var bd_level = data.bd_level;

            // загрузка списка категорий
            $.getJSON("http://web.std-237.ist.mospolytech.ru/api/bd/read.php", function(data){

              

                // сохраним html в переменной «update product»
                var update_product_html=`
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>

    <!-- построение формы для изменения товара -->
    <!-- мы используем свойство 'required' html5 для предотвращения пустых полей -->
    <form id='update-product-form' action='#' method='post' border='0'class=' form_auth form light_blue'>
                 
		
		<div class="form__label"> id базы данных</div>
		<div>
		<input value="` + bd_id + `"  name='bd_id' class='form__input input form-control' required />
        </div>


        <div class="form__label"> Название базы данных</div>
		<div><input  value="` + bd_name + `" name='bd_name' class='form__input input form-control' required /></div>

        <div class="form__label"> Область применения </div>
		<div><input value="` + bd_application + `"  name='bd_application' class='form__input input form-control' required /></div>
		
		<div class="form__label"> Объем </div>
		 <div><input value="` + bd_volume + `"  name='bd_volume' class='form__input input form-control' required /></div>
		

		
		          

            

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
            url: "http://web.std-237.ist.mospolytech.ru/api/bd/update.php",
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