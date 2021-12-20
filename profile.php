<?php

require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/functions/token.php";


if (isset($_COOKIE["token"])) {
    $user = fetchAdminByToken($dbh, $_COOKIE["token"]);
    if ($user) {
        header("Location: /company-profile.php");
    }
}

if (isset($_COOKIE["token"])) {
    $worker = fetchWorkerByToken($dbh, $_COOKIE["token"]);
    if ($worker) {
        header("Location: /lk-worker.php");
    }
}


if (isset($_POST['admin_submit'])) {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $company_name = $_POST['company_name'];
    $admin_password = $_POST['admin_password'];

    $sql = "SELECT * FROM `company_admins` WHERE `admin_name` = :admin_name";
    $params = [
        "admin_name" => $admin_name
    ];

    $fetchUser = $dbh->prepare($sql);
    $fetchUser->execute($params);
    $user = $fetchUser->fetch(PDO::FETCH_ASSOC);


    if (!$user || !password_verify($admin_password, $user["admin_password"])) {
        echo '<div style="color: red;">Неверный логин или пароль</div>';
        // echo $user["admin_id"];
    } else {
        $token = generateToken();
        updateAdminToken($dbh, $user["admin_id"], $token);
        setcookie("token", $token);
        header("Location: /company-profile.php");
    }
    // var_dump($user["admin_id"]);
}

if (isset($_POST['worker_submit'])) {
    $worker_id = $_POST['worker_id'];
    $worker_login = $_POST['worker_login'];
    $company_name = $_POST['company_name'];
    $worker_password = $_POST['worker_password'];

    $sql = "SELECT * FROM `workers` WHERE `worker_login` = :worker_login";
    $params = [
        "worker_login" => $worker_login
    ];

    $fetchUser = $dbh->prepare($sql);
    $fetchUser->execute($params);
    $worker = $fetchUser->fetch(PDO::FETCH_ASSOC);


    if (!$worker || !password_verify($worker_password, $worker["worker_password"])) {
        echo '<div style="color: red;">Неверный логин или пароль</div>';
        // echo $worker["worker_id"];
    } else {
        $token = generateToken();
        updateWorkerToken($dbh, $worker["worker_id"], $token);
        setcookie("token", $token);
        header("Location: /lk-worker.php");
    }
    // var_dump($worker["worker_id"]);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <meta name="description" content="Организуем корпоративное питание. Работаем с НДС. Получите расчет стоимости! · Доставка в удобное время. Работаем более 8 лет. Работаем с НДС. Все способы оплаты. Собственное производство. Свой штат курьеров">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profile-style.css">
    <link rel="stylesheet" href="icon.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
</head>

<body>
    <!-- <form action="company-profile.php" method="post">
        <input type="text" name="test">
        <button type="submit">Test</button>
    </form> -->
    <div class="wrapper">
        <a href="index.html" class="back__btn">
            <img src="img/corp_logo.png" alt="back">
        </a>
        <div class="profiles">
            <div class="container">
                <div class="profiles-title">
                    Добро пожаловать!
                </div>
                <div class="profiles-title-app">
                    TYTEDA.APP
                </div>
                <div class="profiles-subtitle">
                    Выберите Вашу компанию:
                </div>
                <div class="profile-searche">
                    <a href="#" class="profile-searche__btn">
                        <img src="img/loop.png" alt="">
                    </a>
                    <input class="profile-searche__input searche-input" type="text" placeholder="Поиск по названию компании">
                </div>
                <div class="profiles__companies">
                    <?php

                    $sql = "SELECT * FROM `companies`";
                    $rows = $dbh->query($sql);
                    foreach ($rows as $row) {
                    ?>
                        <a href="#<?php echo $row['name'] ?>" class="profile-company-wrapper popup-link">
                            <div class="profile-company">
                                <div class="profile-company__img _ibg">
                                    <img src="img/companies/<?php echo $row['img'] ?>" alt="">
                                </div>
                                <div class="profile-company__body">
                                    <div class="profile-company__title">
                                        <?php echo $row['name'] ?>
                                    </div>
                                    <div class="profile-company__btn btn">
                                        Войти
                                    </div>
                                </div>
                            </div>
                        </a>

                    <?php } ?>
                </div>
            </div>
        </div>
        <footer>
            <div class="footer-first">
                <div class="container">
                    <div class="footer-wrapper">
                        <div class="footer-block">
                            <p class="footer-title">Дополнительно</p>
                            <ul>
                                <li><a href="https://tyteda.ru/korporativnoe-pitanie/">Корпоративное питание</a>
                                </li>
                                <li><a href="https://tyteda.ru/bankyety-na-domu-i-v-ofisye/">Кейтеринг</a>
                                </li>
                                <li><a href="https://tyteda.ru/oformlenie-zakaza/">Торты на заказ</a></li>
                                <li><a href="https://tyteda.ru/programma-loyalnosti/">Готовая еда на неделю</a></li>
                            </ul>
                        </div>
                        <div class="footer-block">
                            <p class="footer-title">ТутЕда.
                                <br>
                                Корпоративное питание
                            </p>
                            <ul>
                                <li><a href="#">О нас</a></li>
                                <li><a href="#">Тарифы</a></li>
                                <li><a href="#">Форма оплаты</a></li>
                                <li><a href="#">Политика конфиденциальности</a></li>
                            </ul>
                        </div>
                        <div id="contact" class="footer-block">
                            <p class="footer-title">Контакты</p>
                            <ul>
                                <li>24 часа</li>
                                <li><a href="tel:+74951396611">8 (495) 139-66-11</a></li>
                                <li><a href="mailto:corp-pitanie@tyteda.ru">corp-pitanie@tyteda.ru</a></li>
                            </ul>
                        </div>
                        <div class="footer-block">
                            <p>Реутов,<br>
                                ул. Гагарина 42/10</p>
                            <ul class="footer-social">
                                <li><a target="_blank" href="https://vk.com/tyted_a"><img src="/img/vk.svg" alt="Логотип Вконтакте"></a></li>
                                <li><a target="_blank" href="https://www.instagram.com/tyteda.ru/?igshid=6n5q4u0dy7aw"><img src="/img/instagram.svg" alt="Логотип Инстаграм"></a></li>
                                <!--<li><a href="#"><img src="/img/youtube.svg" alt="Логотип Ютуб"></a></li>-->
                                <li><a target="_blank" href="https://www.facebook.com/tyteda.ru/"><img src="/img/facebook.svg" alt="Логотип Фейсбук"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-second">
                <div class="container">
                    <div class="footer-second-info">
                        <p>ООО "БКФ"</p>
                        <p>ОГРН: 5177746201221</p>
                        <p>ИНН: 7720402524</p>
                        <p>Не является публичной офертой</p>
                        <p>2021 Сделано <span style="color: #2294f2">WeTop digital agency</span></p>
                    </div>
                    <div class="footer-second-pay">
                        <img src="img/vise.svg" alt="Виза">
                        <img src="img/mastercard.svg" alt="Мастеркард">
                        <img src="img/mir.svg" alt="Мир">
                        <img src="img/paykeeper.svg" alt="Паейкипер">
                    </div>
                </div>
            </div>
        </footer>


        <?php

        $sql = "SELECT * FROM `companies`";
        $rows = $dbh->query($sql);
        foreach ($rows as $row) {
        ?>
            <div id="<?php echo $row['name'] ?>" class="popup">
                <div class="popup__body">
                    <div class="popup__content">
                        <a href="#header" class="popup__close close-popup">
                            <img src="img/close.png" alt="">
                        </a>
                        <div class="form">
                            <form action="profile.php" method="post" class="register-form">
                                <div class="popup__content-title">
                                    Войти в личный кабинет администратора<span></span>
                                </div>
                                <input readonly class="popup__content-company" type="text" name="company_name" value="<?php echo $row['name']; ?>">
                                <input type="text" name="admin_name" placeholder="Введите Имя" />
                                <input type="password" name="admin_password" placeholder="Введите пароль" />
                                <button type="submit" name="admin_submit" class="register-form__btn btn">Войти</button>
                                <p class="message">Вход для сотрудника <a href="#">Войти</a></p>
                            </form>
                            <form action="profile.php" method="POST" class="login-form">
                                <div class="popup__content-title">
                                    Войти в личный кабинет сотрудника<span></span>
                                </div>
                                <input readonly class="popup__content-company" type="text" name="company_name" value="<?php echo $row['name']; ?>">
                                <input type="text" name="worker_login" placeholder="Введите Логин" />
                                <input type="password" name="worker_password" placeholder="Введите пароль" />
                                <button type="submit" name="worker_submit" class="register-form__btn btn">Войти</button>
                                <p class="message">Вход для администратора <a href="#">Войти</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="script.js"></script>
    <script>
        window.onload = () => {
            let input = document.querySelector('.profile-searche__input');
            let hrefAttr = document.querySelector('.profile-company-wrapper');
            // let profileComp = document.querySelectorAll('.profile-company');
            // console.log(hrefAttr.getAttribute('href').replace('#', ''));


            input.oninput = function() {
                let value = this.value.trim().toLowerCase();
                let list = document.querySelectorAll('.profile-company-wrapper');
                let listtitle = document.querySelectorAll('.profile-company__title');

                if (value) {
                    list.forEach(elem => {
                        if (elem.getAttribute('href').replace('#', '').toLowerCase().search(value) == -1) {
                            elem.classList.add('hide');

                        } else {
                            list.forEach(elem => {
                                elem.classList.remove('hide');
                            });
                        }
                    });
                }

                // if (value) {
                //     console.log('GO')
                //     listtitle.forEach(elem => {
                //         if (elem.innerText.search(value) == -1) {
                //             elem.classList.add('hide');
                //         }
                //     });
                // } else {
                //     listtitle.forEach(elem => {
                //         elem.classList.remove('hide');
                //     });
                // }

                // value
                //     ? list.forEach(elem => {
                //         elem.innerText.search(value) == -1
                //             ? elem.classList.add('hide')
                //             : elem.classList.remove('hide');
                //     })
                //     : list.forEach(elem => {
                //         elem.classList.remove('hide');
                //     });
            };
        };
    </script>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(69306538, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/69306538" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</body>

</html>