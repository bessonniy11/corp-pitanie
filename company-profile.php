<?php
require_once __DIR__ . "/database/database.php";
require_once __DIR__ . "/functions/token.php";


// echo $_COOKIE["token"];
if (isset($_POST['logout_submit'])) {
    setcookie("token", NULL);
    updateAdminToken($dbh, $user["admin_id"], $token);
    unset($_COOKIE);
    header("Location: /profile.php");
}

if (isset($_COOKIE["token"])) {
    $user = fetchAdminByToken($dbh, $_COOKIE["token"]);
    if (!$user) {
        header("Location: /profile.php");
    }
} else {
    header("Location: /profile.php");
}

if (isset($_POST['del_worker_btn'])) {
    $del_worker = $_POST['del_worker'];
    $del_id = $_POST['del_worker_id'];

    // echo $del_company;

    $query2 = "DELETE FROM `workers` WHERE `worker_id` = '$del_id'";
    $dbh->exec($query2);
}

if (isset($_POST['worker_reg'])) {
    $worker_name = $_POST['worker_name'];
    $worker_login = $_POST['worker_login'];
    $worker_phone = $_POST['worker_phone'];
    $worker_company = $_POST['worker_company'];
    $worker_password = $_POST['worker_password'];
    $worker_pass_confirm = $_POST['worker_pass_confirm'];

    $errors = [];

    if (empty($worker_name)) {
        $errors['worker_login'] = true;
    }
    if (empty($worker_password) || empty($worker_pass_confirm) || $worker_password != $worker_pass_confirm) {
        $errors['$worker_password'] = true;
    }

    if (empty($errors)) {
        $sql = "INSERT INTO `workers`(`worker_login`, `worker_name`,`worker_company`, `worker_password`, `worker_phone`) VALUES (:worker_login, :worker_name, :worker_company, :worker_password, :worker_phone)";
        $params = [
            "worker_login" => $worker_login,
            "worker_name" => $worker_name,
            "worker_company" => $worker_company,
            "worker_phone" => $worker_phone,
            "worker_password" => password_hash($worker_password, PASSWORD_DEFAULT)
        ];
        var_dump($params);
        $dbh->prepare($sql)->execute($params);
        header("Location: /company-profile.php");
    }
}

$adminCompany = $user['admin_company'];
$sql = "SELECT * FROM `companies` WHERE `name` = :admincompany";
// echo $adminCompany;
$params = [
    "admincompany" => $adminCompany
];
$fetchCompany = $dbh->prepare($sql);
$fetchCompany->execute($params);
$companyImg = $fetchCompany->fetch(PDO::FETCH_ASSOC);

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
    <link rel="stylesheet" href="profile-style.css">
    <link rel="stylesheet" href="css/company-profile.css">
    <link rel="stylesheet" href="icon.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
</head>

<body>
    <div class="wrapper">
        <a href="index.html" class="back__btn">
            <img src="img/corp_logo.png" alt="back">
        </a>
        <div class="company-profile _tabs">
            <div class="company-profile__logo">
                <img src="img/companies/<?= $companyImg['img'] ?>" alt="">
            </div>
            <form action="company-profile.php" method="POST">
                <button type="submit" name="logout_submit" class="company-profile__out">
                    Выход
                </button>
            </form>
            <div class="tabs-block company-profile__switches">
                <div class="company-profile__switch _tabs-item _active">
                    Сотрудники
                </div>
                <div class="company-profile__switch _tabs-item  admin-menu">
                    Меню
                </div>
            </div>

            <div class="_tabs-block _active">
                <div class="company-profile__searche">
                    <a href="#" class="profile-searche__btn">
                        <img src="img/loop.png" alt="">
                    </a>
                    <input class="worker-searche__input searche-input" type="text" placeholder="Поиск сотрудников">
                </div>
                <div class="company-profile__add-worker">
                    <!-- <a href="#" class="profile-searche__btn"> -->
                    <img src="img/plus.svg" alt="">
                    <!-- </a> -->
                    <a href="#newworker" class="add-worker__btn popup-link">
                        Добавить нового сотрудника
                    </a>
                </div>
                <div class="company-profile__list workers-list">
                    <ul>
                        <?php
                        $adminCompany = $user['admin_company'];
                        // echo $adminCompany;
                        $sql = "SELECT * FROM `workers` WHERE `worker_company` = '$adminCompany'";
                        $rows = $dbh->query($sql);
                        foreach ($rows as $row) {
                        ?>
                            <li class="workers-list__item">
                                <a href="" class="workers-list__link"><?php echo $row['worker_name'] ?></a>
                                <div class="workers-list__item-btns">
                                    <div class="item-btn__status">
                                        <img src="img/status-ok.svg" alt="">
                                    </div>
                                    <a href="<?php echo $row['worker_id'] ?>" class="item-btn__del popup-link">
                                        <img src="img/worker-del.svg" alt="">
                                    </a>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="_tabs-block ">
                <div class="container">
                    <div class="company-menu">
                        <div class="company-menu__tarifs tarif">
                            <div class="tarif-item tarif-you">Ваш тариф:</div>
                            <div class="tarifs__control">
                                <div class="tarif-item tarif-selected" id="tarif-selected">
                                    Мини (от 200р)
                                </div>
                                <div class="tarif-item tarif-changed">
                                    <div class="tarif-changed__link">ИЗМЕНИТЬ ТАРИФ</div>
                                    <div class="tarif-changed__body tarif-changed">
                                        <ul class="tarif-changed__list">
                                            <li class="tarif-changed__item">
                                                <div href="" class="tarif-changed__link">Мини (от 200р)</div>
                                            </li>
                                            <li class="tarif-changed__item">
                                                <div href="" class="tarif-changed__link">Стандарт (от 250р)</div>
                                            </li>
                                            <li class="tarif-changed__item">
                                                <div href="" class="tarif-changed__link">Комфорт (от 350р)</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="company-menu__body menu-body _menu _menutab tarif-1">
                            <div class="menu-body__contol control-menu">
                                <div class="control-menu__btns">
                                    <div class="control-menu__btn _tabs-items">ЗАВТРАК</div>
                                    <div class="control-menu__btn _tabs-items _active">ОБЕД</div>
                                    <div class="control-menu__btn _tabs-items">УЖИН</div>
                                </div>
                                <div class="control-menu__desc desc-control">
                                    <div class="desc-control__name">ОБЕД:</div>
                                    <ul class="desc-control__list">
                                        <li class="desc-control__item">СУПЫ: 350мл</li>
                                        <li class="desc-control__item">ГАРНИРЫ: 180гр</li>
                                        <li class="desc-control__item">ГОРЯЧЕЕ: 100гр</li>
                                        <li class="desc-control__item">САЛАТЫ: 130гр</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                1
                            </div>
                            <div class="menu-body__items _tabs-blocks _active">
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Borsh.png" alt="">
                                    </div>
                                    <div class="body-item__name">СУПЫ</div>
                                    <a href="#soups_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KartofelPoDerevenski.png" alt="">
                                    </div>
                                    <div class="body-item__name">ГАРНИРЫ</div>
                                    <a href="#garniry_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KryloZhar.png" alt="">
                                    </div>
                                    <div class="body-item__name">ГОРЯЧЕЕ</div>
                                    <a href="#goryachee_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Seldpodshuboy.png" alt="">
                                    </div>
                                    <div class="body-item__name">САЛАТЫ</div>
                                    <a href="#salats_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                3
                            </div>
                        </div>
                        <div class="company-menu__body menu-body _menu _menutab tarif-2">
                            <div class="menu-body__contol control-menu">
                                <div class="control-menu__btns">
                                    <div class="control-menu__btn _tabs-items">ЗАВТРАК</div>
                                    <div class="control-menu__btn _tabs-items _active">ОБЕД</div>
                                    <div class="control-menu__btn _tabs-items">УЖИН</div>
                                </div>
                                <div class="control-menu__desc desc-control">
                                    <div class="desc-control__name">ОБЕД:</div>
                                    <ul class="desc-control__list">
                                        <li class="desc-control__item">СУПЫ: 350мл</li>
                                        <li class="desc-control__item">ГАРНИРЫ: 180гр</li>
                                        <li class="desc-control__item">ГОРЯЧЕЕ: 100гр</li>
                                        <li class="desc-control__item">САЛАТЫ: 130гр</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                1
                            </div>
                            <div class="menu-body__items _tabs-blocks _active">
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Borsh.png" alt="">
                                    </div>
                                    <div class="body-item__name">СУПЫ</div>
                                    <a href="#soups_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KartofelPoDerevenski.png" alt="">
                                    </div>
                                    <div class="body-item__name">ГАРНИРЫ</div>
                                    <a href="#garniry_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KryloZhar.png" alt="">
                                    </div>
                                    <div class="body-item__name">ГОРЯЧЕЕ</div>
                                    <a href="#goryachee_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Seldpodshuboy.png" alt="">
                                    </div>
                                    <div class="body-item__name">САЛАТЫ</div>
                                    <a href="#salats_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                3
                            </div>
                        </div>
                        <div class="company-menu__body menu-body _menu _menutab tarif-3">
                            <div class="menu-body__contol control-menu">
                                <div class="control-menu__btns">
                                    <div class="control-menu__btn _tabs-items">ЗАВТРАК</div>
                                    <div class="control-menu__btn _tabs-items _active">ОБЕД</div>
                                    <div class="control-menu__btn _tabs-items">УЖИН</div>
                                </div>
                                <div class="control-menu__desc desc-control">
                                    <div class="desc-control__name">ОБЕД:</div>
                                    <ul class="desc-control__list">
                                        <li class="desc-control__item">СУПЫ: 350мл</li>
                                        <li class="desc-control__item">ГАРНИРЫ: 180гр</li>
                                        <li class="desc-control__item">ГОРЯЧЕЕ: 100гр</li>
                                        <li class="desc-control__item">САЛАТЫ: 130гр</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                1
                            </div>
                            <div class="menu-body__items _tabs-blocks _active">
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Borsh.png" alt="">
                                    </div>
                                    <div class="body-item__name">СУПЫ</div>
                                    <a href="#soups_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KartofelPoDerevenski.png" alt="">
                                    </div>
                                    <div class="body-item__name">ГАРНИРЫ</div>
                                    <a href="#garniry_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KryloZhar.png" alt="">
                                    </div>
                                    <div class="body-item__name">ГОРЯЧЕЕ</div>
                                    <a href="#goryachee_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Seldpodshuboy.png" alt="">
                                    </div>
                                    <div class="body-item__name">САЛАТЫ</div>
                                    <a href="#salats_popup" class="body-item__btn popup-link">СМОТРЕТЬ</a>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                3
                            </div>
                        </div>
                        <div class="menu-body__drink drink-body">
                            <div class="drink-body__info info-drink">
                                <div class="info-drink__name">
                                    НАПИТКИ:
                                </div>
                                <div class="info-drink__vol">
                                    Объём: 500мл
                                </div>
                            </div>
                            <div class="drink-body__items">
                                <div class="drink-body__item drink-item">
                                    <div class="drink-item__img">
                                        <img src="img/mors-yagogny.png" alt="">
                                    </div>
                                    <div class="drink-item__name">
                                        МОРС
                                    </div>
                                </div>
                                <div class="drink-body__item drink-item">
                                    <div class="drink-item__img">
                                        <img src="img/compot-suhofruct.png" alt="">
                                    </div>
                                    <div class="drink-item__name">
                                        КОМПОТ
                                    </div>
                                </div>
                                <div class="drink-body__item drink-item">
                                    <div class="drink-item__img">
                                        <img src="img/tan.png" alt="">
                                    </div>
                                    <div class="drink-item__name">
                                        ТАН
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <li><a href="#"><img src="/img/youtube.svg" alt="Логотип Ютуб"></a></li>
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
        <div id="newworker" class="popup">
            <div class="popup__body">
                <div class="popup__content newworker">
                    <a href="#header" class="popup__close close-popup">
                        <img src="img/close.png" alt="">
                    </a>
                    <div class="form">
                        <form action="company-profile.php" method="POST" class="login-form">
                            <input type="text" hidden class="login-form__img" value="">
                            <div class="popup__content-title">
                                Добавить нового сотрудника<span></span>
                            </div>
                            <input readonly class="popup__content-company" name="worker_company" value="<?= $companyImg['name'] ?>">
                            <input type="text" name="worker_name" placeholder="Введите ФИО" />
                            <input type="text" name="worker_login" placeholder="Введите Логин" />
                            <input type="tel" name="worker_phone" placeholder="Телефон сотрудника" data-validate-field="tel" />
                            <input type="password" name="worker_password" placeholder="Пароль" />
                            <input type="password" name="worker_pass_confirm" placeholder="Подтвердить" />
                            <button type="submit" name="worker_reg" class="register-form__btn btn">Добавить</button>
                            <!-- <p class="message">Вход для администратора <a href="#">Войти</a></p> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $sql = "SELECT * FROM `workers`";
        $rows = $dbh->query($sql);
        foreach ($rows as $row) {
        ?>
            <div id="<?php echo $row['worker_id'] ?>" class="popup popup_add">
                <form class="popup__body" action="company-profile.php" method="POST">
                    <div class="popup__content delete-style">
                        <div class="popup__close _icon-close"></div>
                        <div class="popup-delete__title ">
                            Вы уверены, что хотите удалить <?php echo $row['worker_name'] ?>?
                        </div>
                        <input hidden type="text" name="del_worker" value="<?php echo $row['worker_name'] ?>">
                        <input hidden type="text" name="del_worker_id" value="<?php echo $row['worker_id'] ?>">
                        <div class="popup-delete__btns">
                            <button class="popup-delete__btn" type="submit" name="del_worker_btn">
                                Да, конечно!
                            </button>
                            <a class="popup-delete__btn popup-delete__btn-no close-popup">
                                Не удалять!
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
        <!-- <div id="delworker" class="popup popup_del">
            <div class="popup__body ">
                <div class="popup__content delete-style">
                    <div class="popup__close _icon-close"></div>
                    <div class="popup-delete__title ">
                        Вы уверены, что хотите удалить этого сотрудника?
                    </div>
                    <div class="popup-delete__btns">
                        <a class="popup-delete__btn btn" href="?id=666">
                            Да, конечно!
                        </a>
                        <a class="popup-delete__btn btn popup-delete__btn-no close-popup">
                            Не удалять!
                        </a>
                    </div>
                </div>
            </div>
        </div> -->
        <div id="soups_popup" class="popup">
            <div class="popup__body ">
                <div class="popup__content change_popup">
                    <div class="popup__close _icon-close"></div>
                    <div class="change_popup__title">
                        Супы
                    </div>
                    <div class="change_popup__items">
                        <div class="change_popup__item">
                            <img src="img/Borsh.png" alt="">
                            <div class="change_popup__status">
                                В меню
                            </div>
                        </div>
                        <div class="change_popup__item">
                            <img src="img/Borsh.png" alt="">
                            <div class="change_popup__status">
                                В меню
                            </div>
                        </div>
                        <div class="change_popup__item">
                            <img src="img/Borsh.png" alt="">
                            <div class="change_popup__status">
                                В меню
                            </div>
                        </div>
                        <div class="change_popup__item">
                            <img src="img/Borsh.png" alt="">
                            <div class="change_popup__status">
                                В меню
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div id="garniry_popup" class="popup">
            <div class="popup__body ">
                <div class="popup__content change_popup">
                    <div class="popup__close _icon-close"></div>

                </div>
            </div>
        </div>
        <div id="goryachee_popup" class="popup">
            <div class="popup__body ">
                <div class="popup__content change_popup">
                    <div class="popup__close _icon-close"></div>

                </div>
            </div>
        </div>
        <div id="salats_popup" class="popup change_popup">
            <div class="popup__body ">
                <div class="popup__content change_popup">
                    <div class="popup__close _icon-close"></div>

                </div>
            </div>
        </div>
    </div>
    <script src="js/just-validate.min.js"></script>
    <script src="js/inputmask.min.js"></script>
    <script src="js/common.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="script.js"></script>
    <script>
        // search
        window.onload = () => {
            let workerSearch = document.querySelector('.worker-searche__input');
            // let hrefAttr = document.querySelector('.profile-company-wrapper');
            // let profileComp = document.querySelectorAll('.profile-company');
            // console.log(hrefAttr.getAttribute('href').replace('#', ''));


            workerSearch.oninput = function() {
                let value = this.value.trim().toLowerCase();
                let list = document.querySelectorAll('.workers-list__link');
                // let listtitle = document.querySelectorAll('.profile-company__title');

                if (value != '') {
                    list.forEach(elem => {
                        if (elem.innerText.toLowerCase().search(value) == -1) {
                            elem.parentElement.classList.add('hide');

                        } else {
                            list.forEach(elem => {
                                elem.parentElement.classList.remove('hide');
                            });
                        }
                    });
                }
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