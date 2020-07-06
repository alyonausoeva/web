<?php
session_start();
?>
<html>
<head>
    <link href="app/assets/css/style.less" type="text/css" rel="stylesheet/less"/>
	
    <script src="app/assets/js/less.min.js" type="text/javascript"></script>
    
    <link rel="stylesheet" href="app/assets/css/vegas.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300&display=swap" rel="stylesheet">
    <title>НТЦ "Информрегистрцентр"</title>

</head>

<body class="unsplashapi">

<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://jaysalvat.github.io/vegas/releases/latest/vegas.min.js"></script>
<script src="app/assets/js/unsplash.js" id="rendered-js"></script>

<main >

    <div class="auth">
        <div class="auth_title title">
            <p>
                ИС Государственного регистра баз данных
            </p>
        </div>

        <div class="form_auth form light_blue">
            <div class="form__name">
                Авторизация
            </div>
            <form class="form__content" method="post" action="api/config/log.php">
                <div class="form__label"> Логин</div>
                <div>
                    <input class="form__input input" name="officer_id" type="text" required>
                </div>

                <div class="form__label"> Пароль </div>
                <div>
                    <input class="form__input input" name="officer_pas" type="password" required>
                </div>

                <div class="form__submit ">
                    <input class="form__button blue input" type="submit" name="submit" value="Войти">
                </div>
<?php
    if ($_SESSION['message']){
        echo '<p class="msg">'.$_SESSION['message'].'</p>';
    }
    
    unset($_SESSION['message']);
    ?>
            </form>
        </div>
    </div>
	 
</main>

</body>
