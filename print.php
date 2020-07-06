

<html>
<head>
    <link href="app/assets/css/style.less" rel="stylesheet" type="text/less"/>
    <script src="app/assets/js/less.min.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300&display=swap" rel="stylesheet">
    <title>НТЦ "Информрегистр"</title>

</head>


<body>


<header class="hide">
    <div class="">
        <div class="menu_logo">
            <div class="menu_item">
                <a href="main3.php"> Информрегистр </a>
            </div>
        </div>

        <div class="menu_actions">
            <div class="menu_item light_blue">
                <a href="contract.html">заявки</a>
            </div>
            <div class="menu_item light_blue">
                <a href="bd.html">базы данных</a>
            </div>
            <div class="menu_item light_blue">
                <a href="klient.html">клиенты</a>
            </div>
            <div class="menu_item light_blue">
                <a href="pay.html" >оплата</a>
            </div>
            <div class="menu_item light_blue">
                <a href="certificate.html">свидетельства</a>
            </div>
            <div class="menu_item light_blue">
                <a href="department.html">отделы</a>
            </div>
            <div class="menu_item light_blue">
                <a href="officer.html">сотрудники</a>
            </div>
        </div>

        <div class="menu_profile">
            <div class="menu_item light_blue">
                <a href="profile.html"> мой профиль </a>
            </div>
        </div>
    </div>
</header>

<main>
    <div class=" hide">

        <div class=" hide">
            Регистр баз данных
        </div>


        <div class=" hide">
            <div class="dashboard__picture">
                <img src="/app/assets/img/boy.jpg">
            </div>

            <div class="dashboard__text hide">
                <p><strong> ИС регистра баз данных </strong> предназначена для обеспечения
                    хранение и обработки информации о регистрируемых объектах. Эта организация
                    регистрирует базы банных общего доступа.</p>
                <p>
                    Если говорить упрощенно, то <strong> база данных </strong> – это определённое количество собранной воедино информации, которая структурирована таким образом, чтобы компьютер мог обращаться к ней и работать с имеющимися в ней сведениями.
                </p>
                <p>
                    В современных условиях, когда нарушение <strong> интеллектуальных прав </strong> в виртуальном пространстве (особенно в российском) имеет всеобъемлющий характер, получение подтверждения исключительных прав на любые результаты интеллектуальной деятельности, и на базы данных в том числе, жизненно необходимо. Это гарантия хоть и не абсолютной, но максимально возможной охраны ваших авторских прав и получения полагающихся отчислений. Именно для этого, в частности, и нужна <strong> регистрация базы данных </strong>
                </p>
            </div>
        </div>



    </div>

    <div class="">
        <div class=" hide">
            <div>
                Статистика
            </div>

            <div class="greycolor button t hide">
                <a href="print.php" >Печать</a>
            </div>

        </div>




        <?php
        //$data = json_decode(include(__DIR__ . "/api/log/read.php"), true);
        $data = include __DIR__ . "/api/log/read.php";
        $data = $data['records'];
        ?>

        <div class="statistic" >
            <?php if (is_array($data)) : ?>
                <?php  foreach ($data as $item) : ?>
                    <div class="stat_in">
                        <div class="stat_one">
                            <div class=" print_item" ><?= $item['data'] ?></div>
                            <div class="print_item "><?= $item['date'] ?></div>
                            <div class="print_item "><?= $item['type'] ?></div>
                            <div class=" print_item"><?= $item['status'] ?></div>
                        </div>

                        <div class="print_item"><?= $item['body'] ?></div>
                    </div>


                <?php endforeach; ?>
            <?php else : ?>
                <p><?= $data ?></p>
            <?php endif; ?>
        </div>

    </div>



</main>

</body>