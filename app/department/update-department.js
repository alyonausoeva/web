jQuery(function($){

    // показывать html форму при нажатии кнопки «Обновить товар»
    $(document).on('click', '.update-product-button', function(){

        // получаем ID товара
        var department_id = $(this).attr('data-department_id');
        // читаем одну запись на основе данного идентификатора товара
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/department/read_one.php?department_id=" + department_id, function(data){

            // значения будут использоваться для заполнения нашей формы
            var department_id = data.department_id;
			var department_name = data.department_name;
            
			
            var department_officers = data.department_officers;
            
           

            // загрузка списка категорий
            $.getJSON("http://web.std-237.ist.mospolytech.ru/api/department/read.php", function(data){

              

                // сохраним html в переменной «update product»
                var update_product_html=`
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>

    <!-- построение формы для изменения товара -->
    <!-- мы используем свойство 'required' html5 для предотвращения пустых полей -->
    <form id='update-product-form' action='#' method='post' border='0'class=' form_auth form light_blue'>
                 
		
		<div class="form__label"> id отдела</div>
		<div>
		<input value="` + department_id + `"  name='department_id' class='form__input input form-control' required />
        </div>


        <div class="form__label"> Название отдела</div>
		<div><input  value="` + department_name + `" name='department_name' class='form__input input form-control' required /></div>

        
		
		<div class="form__label"> Количество сотрудников </div>
		 <div><input value="` + department_officers + `"  name='department_officers' class='form__input input form-control' required /></div>
		

		
		          

            

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
            url: "http://web.std-237.ist.mospolytech.ru/api/department/update.php",
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