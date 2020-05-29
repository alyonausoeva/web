jQuery(function($){

    // показывать html форму при нажатии кнопки «Обновить товар»
    $(document).on('click', '.update-product-button', function(){

        // получаем ID товара
        var officer_id = $(this).attr('data-officer_id');
        // читаем одну запись на основе данного идентификатора товара
        $.getJSON("http://web.std-237.ist.mospolytech.ru/api/officer/read_one.php?officer_id=" + officer_id, function(data){

            // значения будут использоваться для заполнения нашей формы
            var officer_id = data.officer_id;
			var officer_name = data.officer_name;
            var department_id = data.department_id;
			
            var officer_pas = data.officer_pas;
            var officer_date = data.officer_date;
            var officer_level = data.officer_level;

            // загрузка списка категорий
            $.getJSON("http://web.std-237.ist.mospolytech.ru/api/officer/read.php", function(data){

              

                // сохраним html в переменной «update product»
                var update_product_html=`
    <div id='read-products'  class='btn  btn-default pull-right m-b-15px read-products-button light_blue '>
        Все записи
    </div>

    <!-- построение формы для изменения товара -->
    <!-- мы используем свойство 'required' html5 для предотвращения пустых полей -->
    <form id='update-product-form' action='#' method='post' border='0'class=' form_auth form light_blue'>
                 
		
		<div class="form__label"> id сотрудника</div>
		<div>
		<input value="` + officer_id + `"  name='officer_id' class='form__input input form-control' required />
        </div>


        <div class="form__label"> ФИО</div>
		<div><input  value="` + officer_name + `" name='officer_name' class='form__input input form-control' required /></div>

        <div class="form__label"> id отдела</div>
		<div><input value="` + department_id + `"  name='department_id' class='form__input input form-control' required /></div>
		
		<div class="form__label"> Паспортные данные</div>
		 <div><input value="` + officer_pas + `"  name='officer_pas' class='form__input input form-control' required /></div>
		
<div class="form__label"> Дата приема на работу</div>
		 <div><input value="` + officer_date + `"  name='officer_date' class='form__input input form-control' required /></div>

<div class="form__label"> Уровень доступа</div>
		 <div><input value="` + officer_level + `"  name='officer_level' class='form__input input form-control' required /></div>
		
		          

            

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
            url: "http://web.std-237.ist.mospolytech.ru/api/officer/update.php",
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