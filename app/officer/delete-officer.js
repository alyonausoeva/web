jQuery(function($){

    // будет работать, если была нажата кнопка удаления
    $(document).on('click', '.delete-product-button', function(){
        // получение ID товара
        var officer_id = $(this).attr('data-officer_id');
        // bootbox для подтверждения во всплывающем окне
        bootbox.confirm({

            message: "<h4>Вы уверены?</h4>",
            buttons: {
                confirm: {
                    label: 'Да',
                    className: 'binput btn shadow btn-danger'
                },
                cancel: {
                    label: ' Нет',
                    className: 'binput greycolor  btn-default shadow'
                }
            },
            callback: function (result) {
                if (result==true) {

                    // отправим запрос на удаление в API / удаленный сервер
                    $.ajax({
                        url: "http://web.std-237.ist.mospolytech.ru/api/officer/delete.php",
                        type : "POST",
                        dataType : 'json',
                        data : JSON.stringify({officer_id: officer_id }),
                        success : function(result) {

                            // покажем список всех товаров
                            showProducts();
                        },
                        error: function(xhr, resp, text) {
                            console.log(xhr, resp, text);
                        }
                    });

                }
            }
        });
    });
});