<?php
require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/functions/token.php";

if (isset($_POST['logout_submit'])) {
    setcookie("token", NULL);
    updateWorkerToken($dbh, $worker["worker_id"], $token);
    unset($_COOKIE);
    header("Location: /profile.php");
}

if (isset($_COOKIE["token"])) {
    $worker = fetchWorkerByToken($dbh, $_COOKIE["token"]);
    if (!$worker) {
        header("Location: /profile.php");
    }
} else {
    header("Location: /profile.php");
}



$workerCompany = $worker['worker_company'];
$sql = "SELECT * FROM `companies` WHERE `name` = :workerCompany";
$params = [
    "workerCompany" => $workerCompany
];
$fetchCompany = $dbh->prepare($sql);
$fetchCompany->execute($params);
$companyImg = $fetchCompany->fetch(PDO::FETCH_ASSOC);


// $workerCompany = $worker['worker_name'];
// $sql = "SELECT * FROM `workers` WHERE `worker_name` = :worker_name";
// $params = [
//     "admincompany" => $workerCompany
// ];
// $fetchCompany = $dbh->prepare($sql);
// $fetchCompany->execute($params);
// $workerTrue = $fetchCompany->fetch(PDO::FETCH_ASSOC);
$companyTarif =  $companyImg['tarif'];


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
    <link rel="icon" href="./img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/lk-worker-style.css">
    <link rel="stylesheet" href="css/profile-style.css">
    <link rel="stylesheet" href="icon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
</head>

<body>
    <div class="wrapper">
        <a href="index.html" class="back__btn">
            <img src="img/corp_logo.png" alt="back">
        </a>
        <div class="worker-profile">
            <div class="container">
                <div class="worker-profile__header profile-header">
                    <div class="profile-header__wrapper">
                        <div class="profile-header__avatar">
                            <img src="img/ava.svg" alt="">
                        </div>
                        <div class="profile-header__name profile-name">
                            <div class="profile-name-first">
                                <?= $worker['worker_name'] ?>
                            </div>
                            <!-- <div class="profile-name-last">
                                Иванов
                            </div> -->
                        </div>
                    </div>
                    <div class="profile-header__company-img">
                        <img src="img/companies/<?= $companyImg['img'] ?>" alt="">
                    </div>
                </div>
                <?php if ($companyTarif == 'Мини (от 200р)') { ?>
                    <div class="worker-profile__body worker-body">
                        <div class="worker-body__timer">
                            Заказы на завтра принимаются до 20:00
                            <!-- <span id="span"> </span> -->
                        </div>
                        <div class="worker-body__title">
                            Выберите меню на <span id="tomorrow"> </span>
                        </div>
                        <form class="worker-body__form form-order">
                            <div class="form-order__items">
                                <div class="form-order__item order-item">
                                    <input hidden type="text" name="worker_name" value="<?= $worker['worker_name'] ?>">
                                    <input hidden type="text" name="worker_company" value="<?= $worker['worker_company'] ?>">
                                    <select name="item1" class="order-item__select select-soups order-item__select-hidden">
                                        <option hidden value="">Выберите</option>
                                        <option value="Гороховый,01.jpg">Гороховый</option>
                                        <option value="Лагман,02.png">Лагман</option>
                                        <option value="Куриный с лапшой,03.png">Куриный с лапшой</option>
                                        <option value="Солянка,04.png">Солянка</option>
                                        <option value="Харчо из баранины,harcho.png">Харчо из баранины</option>
                                        <option value="Шурпа из говядины,shurpa.png">Шурпа из говядины</option>
                                        <option value="Суп-пюре тыквенный,souptykvenniy.png">Суп-пюре тыквенный</option>
                                    </select>
                                    <div class="order-item__img animate__animated order-soups">
                                        <img class="animate__animated order-img" src="img/null.png" alt="">
                                    </div>
                                </div>
                                <!-- <button type="submit" name="order_submit">Order</button> -->
                            </div>
                        </form>
                        <a href="#popup_change" class="form-order__btn btn popup-link">
                            ПОДТВЕРИТЬ ЗАКАЗ
                        </a>
                    </div>
                <?php } ?>
                <?php if ($companyTarif == 'Стандарт (от 250р)') { ?>
                    <div class="worker-profile__body worker-body">
                        <div class="worker-body__timer">
                            Заказы на завтра принимаются до 20:00
                            <!-- <span id="span"> </span> -->
                        </div>
                        <div class="worker-body__title">
                            Выберите меню на <span id="tomorrow"> </span>
                        </div>
                        <form class="worker-body__form form-order">
                            <div class="form-order__items">
                                <div class="form-order__item order-item">
                                    <input hidden type="text" name="worker_name" value="<?= $worker['worker_name'] ?>">
                                    <input hidden type="text" name="worker_company" value="<?= $worker['worker_company'] ?>">
                                    <select name="item1" class="order-item__select select-soups order-item__select-hidden">
                                        <option hidden value="">Выберите</option>
                                        <option value="Гороховый,01.jpg">Гороховый</option>
                                        <option value="Лагман,02.png">Лагман</option>
                                        <option value="Куриный с лапшой,03.png">Куриный с лапшой</option>
                                        <option value="Солянка,04.png">Солянка</option>
                                        <option value="Харчо из баранины,harcho.png">Харчо из баранины</option>
                                        <option value="Шурпа из говядины,shurpa.png">Шурпа из говядины</option>
                                        <option value="Суп-пюре тыквенный,souptykvenniy.png">Суп-пюре тыквенный</option>
                                    </select>
                                    <div class="order-item__img animate__animated order-soups">
                                        <img class="animate__animated order-img" src="img/null.png" alt="">
                                    </div>
                                </div>
                                <div class="form-order__item order-item">
                                    <select id="" class="order-item__select select-salats order-item__select-hidden">
                                        <option hidden value="">Выберите</option>
                                        <option value='Морковь "по-корейски",01.png'>Морковь "по-корейски"</option>
                                        <option value="Греческий,02.png">Греческий</option>
                                        <option value="Куриный с капустой,03.png">Куриный с капустой</option>
                                        <option value="Сельдь под шубой,04.png">Сельдь под шубой</option>
                                        <option value="Капуста квашенная,05.png">Капуста квашенная</option>
                                        <option value="Оливье,06.png">Оливье</option>
                                    </select>
                                    <div class="order-item__img order-salats">
                                        <img class="animate__animated order-img" src="img/null.png" alt="">
                                    </div>
                                </div>
                                <!-- <button type="submit" name="order_submit">Order</button> -->
                            </div>
                        </form>
                        <a href="#popup_change" class="form-order__btn btn popup-link">
                            ПОДТВЕРИТЬ ЗАКАЗ
                        </a>
                    </div>
                <?php } ?>
                <?php if ($companyTarif == 'Комфорт (от 350р)') { ?>
                    <div class="worker-profile__body worker-body">
                        <div class="worker-body__timer">
                            Заказы на завтра принимаются до 20:00
                            <!-- <span id="span"> </span> -->
                        </div>
                        <div class="worker-body__title">
                            Выберите меню на <span id="tomorrow"> </span>
                        </div>
                        <form class="worker-body__form form-order">
                            <div class="form-order__items">
                                <div class="form-order__item order-item">
                                    <input hidden type="text" name="worker_name" value="<?= $worker['worker_name'] ?>">
                                    <input hidden type="text" name="worker_company" value="<?= $worker['worker_company'] ?>">
                                    <select name="item1" class="order-item__select select-soups order-item__select-hidden">
                                        <option hidden value="">Выберите</option>
                                        <option value="Гороховый,01.jpg">Гороховый</option>
                                        <option value="Лагман,02.png">Лагман</option>
                                        <option value="Куриный с лапшой,03.png">Куриный с лапшой</option>
                                        <option value="Солянка,04.png">Солянка</option>
                                        <option value="Харчо из баранины,harcho.png">Харчо из баранины</option>
                                        <option value="Шурпа из говядины,shurpa.png">Шурпа из говядины</option>
                                        <option value="Суп-пюре тыквенный,souptykvenniy.png">Суп-пюре тыквенный</option>
                                    </select>
                                    <div class="order-item__img animate__animated order-soups">
                                        <img class="animate__animated order-img" src="img/null.png" alt="">
                                    </div>
                                </div>
                                <div class="form-order__item order-item">
                                    <select id="" class="order-item__select select-salats order-item__select-hidden">
                                        <option hidden value="">Выберите</option>
                                        <option value='Морковь "по-корейски",01.png'>Морковь "по-корейски"</option>
                                        <option value="Греческий,02.png">Греческий</option>
                                        <option value="Куриный с капустой,03.png">Куриный с капустой</option>
                                        <option value="Сельдь под шубой,04.png">Сельдь под шубой</option>
                                        <option value="Капуста квашенная,05.png">Капуста квашенная</option>
                                        <option value="Оливье,06.png">Оливье</option>
                                    </select>
                                    <div class="order-item__img order-salats">
                                        <img class="animate__animated order-img" src="img/null.png" alt="">
                                    </div>
                                </div>
                                <div class="form-order__item order-item">
                                    <select name="item3" id="" class="order-item__select select-garnir order-item__select-hidden">
                                        <option hidden value="">Выберите</option>
                                        <option value="Гречка,01.png">Гречка</option>
                                        <option value="Рис отварной,02.png">Рис отварной</option>
                                        <option value="Макароны отварные,03.png">Макароны отварные</option>
                                        <option value="Белая фасоль с томатами,04.png">Белая фасоль с томатами</option>
                                        <option value="Капуста цветная,05.png">Капуста цветная</option>
                                        <option value="Пюре картофельное,06.png">Пюре картофельное</option>
                                    </select>
                                    <div class="order-item__img order-garnir">
                                        <img class="animate__animated order-img" src="img/null.png" alt="">
                                    </div>
                                </div>
                                <!-- <button type="submit" name="order_submit">Order</button> -->
                            </div>
                        </form>
                        <a href="#popup_change" class="form-order__btn btn popup-link">
                            ПОДТВЕРИТЬ ЗАКАЗ
                        </a>
                    </div>
                <?php } ?>

                <div>



                </div>
                <form action="company-profile.php" method="POST">
                    <button type="submit" name="logout_submit" class="worker-profile__out">
                        Выход
                    </button>
                </form>
            </div>
        </div>
        <footer>
            <div class="footer-first">
                <div class="container">
                    <div class="footer-wrapper">
                        <div class="footer-block">
                            <p class="footer-title">Дополнительно</p>
                            <ul>
                                <li><a href="https://tyteda.ru/korporativnoe-pitanie/">Корпоративное питание</a></li>
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
        <div class="popup-wrapper">
            <div class="popup-form">
                <div class="close-form"></div>
                <form action="mail.php" method="post">
                    <legend>Заказать корпоративное питание</legend>
                    <div class="form-name">
                        <input type="text" name="name" placeholder="Ваше имя">
                    </div>
                    <div class="form-phone">
                        <input type="number" name="phone" placeholder="+7 (">
                    </div>
                    <div class="form-email">
                        <input type="email" name="email" placeholder="E-mail">
                    </div>
                    <textarea name="message" cols="30" rows="5" placeholder="Сообщение"></textarea>
                    <input type="submit" value="Отправить заявку" class="submit submit-btn">
                </form>
            </div>
        </div>
        <div id="popup_change" class="popup">
            <div class="popup__body">
                <div class="popup__content">
                    <div class="popup__body change-body-important">
                        <a href="#" class="popup__close close-popup">
                            <img src="img/close.png" alt="">
                        </a>

                        <div class="change-body">
                            <!-- <form> -->
                            <div class="popup-change__title">
                                Ваш заказ: <br>
                            </div>
                            <input hidden type="text" id="worker_name" name="worker_name" value="<?= $worker['worker_name'] ?>">
                            <input hidden type="text" id="worker_company" name="worker_company" value="<?= $worker['worker_company'] ?>">
                            <input hidden type="text" class="datefororder" id="datefororder" name="datefororder" value="">
                            <input name="item1" id="item1" readonly class="popup-change__item popup-change__item1">
                            <input name="item2" id="item2" readonly class="popup-change__item popup-change__item2">
                            <input name="item3" id="item3" readonly class="popup-change__item popup-change__item3">
                            <input hidden type="text" id="item4" class="item4" name="item4">
                            <div class="popup-change__btns">
                                <button class="popup-change__btn btn popup-change__btn-yes">
                                    Подтверждаю!
                                </button>
                                <a class="popup-change__btn btn popup-change__btn-no">
                                    Ещё подумаю...
                                </a>
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js"></script>
    <script>
        let selectSoups = document.querySelector('.select-soups');
        let selectSoupsImg = document.querySelector('.order-soups img');

        selectSoups.addEventListener('change', function() {
            selectSoupsImg.src = 'img/menufordelivery/soups-1/' + this.value.split(',')[1];
            selectSoups.classList.remove('order-item__select-hidden');
            selectSoupsImg.classList.add('animate__backInLeft');
            setTimeout(() => {
                selectSoupsImg.classList.remove('animate__backInLeft');
            }, 1000);
        });

        let selectSalats = document.querySelector('.select-salats');
        let selectSalatsImg = document.querySelector('.order-salats img');

        if (selectSalats) {
            selectSalats.addEventListener('change', function() {
                selectSalatsImg.src = 'img/menufordelivery/salats-4/' + this.value.split(',')[1];
                selectSalats.classList.remove('order-item__select-hidden');
                selectSalatsImg.classList.add('animate__backInUp');
                setTimeout(() => {
                    selectSalatsImg.classList.remove('animate__backInUp');
                }, 1000);
            });
        }

        let selectGarnir = document.querySelector('.select-garnir');
        let selectGarnirImg = document.querySelector('.order-garnir img');

        if (selectGarnir) {
            selectGarnir.addEventListener('change', function() {
                selectGarnirImg.src = 'img/menufordelivery/garniry-4/' + this.value.split(',')[1];
                selectGarnir.classList.remove('order-item__select-hidden');
                selectGarnirImg.classList.add('animate__backInRight');
                setTimeout(() => {
                    selectGarnirImg.classList.remove('animate__backInRight');
                }, 1000);
            });
        }
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        let swalBtn = document.querySelector(".popup-change__btn-yes");
        let queBtn = document.querySelector(".form-order__btn");


        queBtn.addEventListener('click', function(e) {
            let selectSoups = document.querySelector(".select-soups");
            let selectSalats = document.querySelector(".select-salats");
            let selectGarnir = document.querySelector(".select-garnir");
            let formItem1 = document.querySelector(".popup-change__item1");
            let formItem2 = document.querySelector(".popup-change__item2");
            let formItem3 = document.querySelector(".popup-change__item3");

            // console.log(selectSoups.value);
            formItem1.value = selectSoups.value.split(',')[0];
            if (selectSalats) {
                formItem2.value = selectSalats.value.split(',')[0];
            }
            if (selectGarnir) {
                formItem3.value = selectGarnir.value.split(',')[0];
            }


            // console.log(selectSoups.getAttribute('data-name'))

        });

        var today2 = new Date();

        var dd = String(today2.getDate()).padStart(2, '0');
        var mm = String(today2.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today2.getFullYear();
        let hoursReal = String(today2.getHours()).padStart(2, '0');
        let minutesReal = String(today2.getMinutes()).padStart(2, '0');
        let secondsReal = String(today2.getSeconds()).padStart(2, '0');

        today2 = mm + '/' + dd + '/' + yyyy + ' ' + hoursReal + ':' + minutesReal + ':' + secondsReal;
        const dateTime = document.getElementById('item4');
        dateTime.value = today2;
    </script>

    <script src="script.js"></script>
    <script>
        // const startDate = new Date('December 20, 2021 21:00:00') //x is just whenever you want to start this: if you
        //don't want to use a backend with a database, you'll need to hardcode this in the javascript

        var today = new Date();

        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        const startDate = new Date(`${today} 21:00:00`);
        // console.log(startDate);


        const timer = document.getElementById('span');
        const tomorrow = document.getElementById('tomorrow');
        const datefororder = document.getElementById('datefororder');

        window.setInterval(() => {
            let date = new Date();

            let hours = 1000 * 60 * 60;
            let minutes = 1000 * 60;
            let seconds = 1000;

            let hoursReal = String(date.getHours()).padStart(2, '0');
            let minutesReal = String(date.getMinutes()).padStart(2, '0');
            let secondsReal = String(date.getSeconds()).padStart(2, '0');


            datefororder.value = `${('0' + (date.getDate() + 1)).slice(-2)}.${(('0' + date.getMonth() + 1)).slice(-2)}.${date.getFullYear()}`;
            tomorrow.innerText = `${('0' + (date.getDate() + 1)).slice(-2)}.${(('0' + date.getMonth() + 1)).slice(-2)}.${date.getFullYear()}`;

        }, 1000);
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