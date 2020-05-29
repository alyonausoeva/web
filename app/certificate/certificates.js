
function readProductsTemplate(data, keywords){

    var read_products_html=`
        <!-- форма поиска товаров -->
		<div class='search'>
        <form id='search-product-form' action='#' method='post'>
            <div class='input-group  pull-left w-50-pct shadow '>
                <input type='text' value='` + keywords + `' name='keywords' class=' binput form-control product-search-keywords' placeholder='Поиск записей...' />

                <span class='input-group-btn '>
                    <button type='submit' class='btn btn-primary blue binput ' type='button'>
                        Поиск
                    </button>
                </span>

            </div>
        </form>

        <!-- при нажатии загружается форма создания продукта -->
        <button id='create-product' class='btn m-b-15px btn-primary  pull-right  create-product-button blue input'>
		
            Создать
			
        </button>
		</div>

        <!-- начало таблицы -->
        <table class='table table-bordered table-hover'>

            <!-- создание заголовков таблицы -->
            <tr>
                <th class='w-5-pct'>id</th>
                <th class='w-25-pct'>Дата выдачи</th>
                <th class='w-15-pct'>id квитанции об оплате </th>
                <th class='w-25-pct text-align-center'>Действие</th>
            </tr>`;

    // перебор возвращаемого списка данных
    $.each(data.records, function(key, val) {

        // создание новой строки таблицы для каждой записи
        read_products_html+=`<tr>

            <td>` + val.certificate_id + `</td>
            <td>` + val.certificate_date + `</td>
            <td>` + val.pay_id + `</td>

            <!-- кнопки 'действий' -->
            <td>
                <!-- кнопка для просмотра товара -->
                <button class='binput bluecolor shadow btn btn-primary m-r-10px read-one-product-button' data-certificate_id='` + val.certificate_id  + `'>
                    Просмотреть
                </button>

                <!-- кнопка для изменения товара -->
                <button class='binput greycolor  btn-default shadow btn  m-r-10px update-product-button' data-certificate_id='` + val.certificate_id  + `'>
                     Редактировать
                </button>

                <!-- кнопка для удаления товара -->
                <button class='binput btn shadow btn-danger delete-product-button' data-certificate_id='` + val.certificate_id  + `'>
                     Удалить
                </button>
            </td>
        </tr>`;
    });

    // конец таблицы
    read_products_html+=`</table>`;
// pagination
    if (data.paging) {
        read_products_html+="<ul class='pagination  pull-left margin-zero padding-bottom-2em'>";

        // первая
        if(data.paging.first!=""){
            read_products_html+="<li><a  data-page='" + data.paging.first + "'>Первая страница</a></li>";
        }

        // перебор страниц
        $.each(data.paging.pages, function(key, val){
            var active_page=val.current_page=="yes" ? "class='active'" : "";
            read_products_html+="<li " + active_page + "><a data-page='" + val.url + "'>" + val.page + "</a></li>";
        });

        // последняя
        if (data.paging.last!="") {
            read_products_html+="<li><a data-page='" + data.paging.last + "'>Последняя страница</a></li>";
        }
        read_products_html+="</ul>";
    }
    // добавим в «page-content» нашего приложения
    $("#page-content").html(read_products_html);
}