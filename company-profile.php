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
    <title>???????????? ??????????????</title>
    <meta name="description" content="???????????????????? ?????????????????????????? ??????????????. ???????????????? ?? ??????. ???????????????? ???????????? ??????????????????! ?? ???????????????? ?? ?????????????? ??????????. ???????????????? ?????????? 8 ??????. ???????????????? ?? ??????. ?????? ?????????????? ????????????. ?????????????????????? ????????????????????????. ???????? ???????? ????????????????">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="./img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/profile-style.css">
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
                    ??????????
                </button>
            </form>
            <div class="tabs-block company-profile__switches">
                <div class="company-profile__switch _tabs-item _active">
                    ????????????????????
                </div>
                <!-- <div class="company-profile__switch _tabs-item  admin-menu">
                    ????????
                </div> -->
            </div>

            <div class="_tabs-block _active">
                <div class="company-profile__searche">
                    <a href="#" class="profile-searche__btn">
                        <img src="img/loop.png" alt="">
                    </a>
                    <input class="worker-searche__input searche-input" type="text" placeholder="?????????? ??????????????????????">
                </div>
                <div class="company-profile__add-worker">
                    <!-- <a href="#" class="profile-searche__btn"> -->
                    <img src="img/plus.svg" alt="">
                    <!-- </a> -->
                    <a href="#newworker" class="add-worker__btn popup-link">
                        ???????????????? ???????????? ????????????????????
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
                            <div class="tarif-item tarif-you">?????? ??????????:</div>
                            <div class="tarifs__control">
                                <div class="tarif-item tarif-selected" id="tarif-selected">
                                    ???????? (???? 200??)
                                </div>
                                <div class="tarif-item tarif-changed">
                                    <div class="tarif-changed__link">???????????????? ??????????</div>
                                    <div class="tarif-changed__body tarif-changed">
                                        <ul class="tarif-changed__list">
                                            <li class="tarif-changed__item">
                                                <div href="" class="tarif-changed__link">???????? (???? 200??)</div>
                                            </li>
                                            <li class="tarif-changed__item">
                                                <div href="" class="tarif-changed__link">???????????????? (???? 250??)</div>
                                            </li>
                                            <li class="tarif-changed__item">
                                                <div href="" class="tarif-changed__link">?????????????? (???? 350??)</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="company-menu__body menu-body _menu _menutab tarif-1">
                            <div class="menu-body__contol control-menu">
                                <div class="control-menu__btns">
                                    <div class="control-menu__btn _tabs-items">??????????????</div>
                                    <div class="control-menu__btn _tabs-items _active">????????</div>
                                    <div class="control-menu__btn _tabs-items">????????</div>
                                </div>
                                <div class="control-menu__desc desc-control">
                                    <div class="desc-control__name">????????:</div>
                                    <ul class="desc-control__list">
                                        <li class="desc-control__item">????????: 350????</li>
                                        <li class="desc-control__item">??????????????: 180????</li>
                                        <li class="desc-control__item">??????????????: 100????</li>
                                        <li class="desc-control__item">????????????: 130????</li>
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
                                    <div class="body-item__name">????????</div>
                                    <a href="#soups_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KartofelPoDerevenski.png" alt="">
                                    </div>
                                    <div class="body-item__name">??????????????</div>
                                    <a href="#garniry_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KryloZhar.png" alt="">
                                    </div>
                                    <div class="body-item__name">??????????????</div>
                                    <a href="#goryachee_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Seldpodshuboy.png" alt="">
                                    </div>
                                    <div class="body-item__name">????????????</div>
                                    <a href="#salats_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                3
                            </div>
                        </div>
                        <div class="company-menu__body menu-body _menu _menutab tarif-2">
                            <div class="menu-body__contol control-menu">
                                <div class="control-menu__btns">
                                    <div class="control-menu__btn _tabs-items">??????????????</div>
                                    <div class="control-menu__btn _tabs-items _active">????????</div>
                                    <div class="control-menu__btn _tabs-items">????????</div>
                                </div>
                                <div class="control-menu__desc desc-control">
                                    <div class="desc-control__name">????????:</div>
                                    <ul class="desc-control__list">
                                        <li class="desc-control__item">????????: 350????</li>
                                        <li class="desc-control__item">??????????????: 180????</li>
                                        <li class="desc-control__item">??????????????: 100????</li>
                                        <li class="desc-control__item">????????????: 130????</li>
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
                                    <div class="body-item__name">????????</div>
                                    <a href="#soups_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KartofelPoDerevenski.png" alt="">
                                    </div>
                                    <div class="body-item__name">??????????????</div>
                                    <a href="#garniry_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KryloZhar.png" alt="">
                                    </div>
                                    <div class="body-item__name">??????????????</div>
                                    <a href="#goryachee_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Seldpodshuboy.png" alt="">
                                    </div>
                                    <div class="body-item__name">????????????</div>
                                    <a href="#salats_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                3
                            </div>
                        </div>
                        <div class="company-menu__body menu-body _menu _menutab tarif-3">
                            <div class="menu-body__contol control-menu">
                                <div class="control-menu__btns">
                                    <div class="control-menu__btn _tabs-items">??????????????</div>
                                    <div class="control-menu__btn _tabs-items _active">????????</div>
                                    <div class="control-menu__btn _tabs-items">????????</div>
                                </div>
                                <div class="control-menu__desc desc-control">
                                    <div class="desc-control__name">????????:</div>
                                    <ul class="desc-control__list">
                                        <li class="desc-control__item">????????: 350????</li>
                                        <li class="desc-control__item">??????????????: 180????</li>
                                        <li class="desc-control__item">??????????????: 100????</li>
                                        <li class="desc-control__item">????????????: 130????</li>
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
                                    <div class="body-item__name">????????</div>
                                    <a href="#soups_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KartofelPoDerevenski.png" alt="">
                                    </div>
                                    <div class="body-item__name">??????????????</div>
                                    <a href="#garniry_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/KryloZhar.png" alt="">
                                    </div>
                                    <div class="body-item__name">??????????????</div>
                                    <a href="#goryachee_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                                <div class="menu-body__item body-item">
                                    <div class="body-item__img">
                                        <img src="img/Seldpodshuboy.png" alt="">
                                    </div>
                                    <div class="body-item__name">????????????</div>
                                    <a href="#salats_popup" class="body-item__btn popup-link">????????????????</a>
                                </div>
                            </div>
                            <div class="menu-body__items _tabs-blocks">
                                3
                            </div>
                        </div>
                        <div class="menu-body__drink drink-body">
                            <div class="drink-body__info info-drink">
                                <div class="info-drink__name">
                                    ??????????????:
                                </div>
                                <div class="info-drink__vol">
                                    ??????????: 500????
                                </div>
                            </div>
                            <div class="drink-body__items">
                                <div class="drink-body__item drink-item">
                                    <div class="drink-item__img">
                                        <img src="img/mors-yagogny.png" alt="">
                                    </div>
                                    <div class="drink-item__name">
                                        ????????
                                    </div>
                                </div>
                                <div class="drink-body__item drink-item">
                                    <div class="drink-item__img">
                                        <img src="img/compot-suhofruct.png" alt="">
                                    </div>
                                    <div class="drink-item__name">
                                        ????????????
                                    </div>
                                </div>
                                <div class="drink-body__item drink-item">
                                    <div class="drink-item__img">
                                        <img src="img/tan.png" alt="">
                                    </div>
                                    <div class="drink-item__name">
                                        ??????
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
                            <p class="footer-title">??????????????????????????</p>
                            <ul>
                                <li><a href="https://tyteda.ru/korporativnoe-pitanie/">?????????????????????????? ??????????????</a></li>
                                <li><a href="https://tyteda.ru/bankyety-na-domu-i-v-ofisye/">??????????????????</a>
                                </li>
                                <li><a href="https://tyteda.ru/oformlenie-zakaza/">?????????? ???? ??????????</a></li>
                                <li><a href="https://tyteda.ru/programma-loyalnosti/">?????????????? ?????? ???? ????????????</a></li>
                            </ul>
                        </div>
                        <div class="footer-block">
                            <p class="footer-title">????????????.
                                <br>
                                ?????????????????????????? ??????????????
                            </p>
                            <ul>
                                <li><a href="#">?? ??????</a></li>
                                <li><a href="#">????????????</a></li>
                                <li><a href="#">?????????? ????????????</a></li>
                                <li><a href="#">???????????????? ????????????????????????????????????</a></li>
                            </ul>
                        </div>
                        <div id="contact" class="footer-block">
                            <p class="footer-title">????????????????</p>
                            <ul>
                                <li>24 ????????</li>
                                <li><a href="tel:+74951396611">8 (495) 139-66-11</a></li>
                                <li><a href="mailto:corp-pitanie@tyteda.ru">corp-pitanie@tyteda.ru</a></li>
                            </ul>
                        </div>
                        <div class="footer-block">
                            <p>????????????,<br>
                                ????. ???????????????? 42/10</p>
                            <ul class="footer-social">
                                <li><a target="_blank" href="https://vk.com/tyted_a"><img src="/img/vk.svg" alt="?????????????? ??????????????????"></a></li>
                                <li><a target="_blank" href="https://www.instagram.com/tyteda.ru/?igshid=6n5q4u0dy7aw"><img src="/img/instagram.svg" alt="?????????????? ??????????????????"></a></li>
                                <li><a href="#"><img src="/img/youtube.svg" alt="?????????????? ????????"></a></li>
                                <li><a target="_blank" href="https://www.facebook.com/tyteda.ru/"><img src="/img/facebook.svg" alt="?????????????? ??????????????"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-second">
                <div class="container">
                    <div class="footer-second-info">
                        <p>?????? "??????"</p>
                        <p>????????: 5177746201221</p>
                        <p>??????: 7720402524</p>
                        <p>???? ???????????????? ?????????????????? ??????????????</p>
                        <p>2021 ?????????????? <span style="color: #2294f2">WeTop digital agency</span></p>
                    </div>
                    <div class="footer-second-pay">
                        <img src="img/vise.svg" alt="????????">
                        <img src="img/mastercard.svg" alt="????????????????????">
                        <img src="img/mir.svg" alt="??????">
                        <img src="img/paykeeper.svg" alt="??????????????????">
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
                                ???????????????? ???????????? ????????????????????<span></span>
                            </div>
                            <input readonly class="popup__content-company" name="worker_company" value="<?= $companyImg['name'] ?>">
                            <input type="text" name="worker_name" placeholder="?????????????? ??????" />
                            <input type="text" required name="worker_login" placeholder="?????????????? ??????????" />
                            <input type="tel" required name="worker_phone" placeholder="?????????????? ????????????????????" data-validate-field="tel" />
                            <input type="password" required name="worker_password" placeholder="????????????" />
                            <input type="password" required name="worker_pass_confirm" placeholder="??????????????????????" />
                            <button type="submit" name="worker_reg" class="register-form__btn btn">????????????????</button>
                            <!-- <p class="message">???????? ?????? ???????????????????????????? <a href="#">??????????</a></p> -->
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
                            ???? ??????????????, ?????? ???????????? ?????????????? <?php echo $row['worker_name'] ?>?
                        </div>
                        <input hidden type="text" name="del_worker" value="<?php echo $row['worker_name'] ?>">
                        <input hidden type="text" name="del_worker_id" value="<?php echo $row['worker_id'] ?>">
                        <div class="popup-delete__btns">
                            <button class="popup-delete__btn" type="submit" name="del_worker_btn">
                                ????, ??????????????!
                            </button>
                            <a class="popup-delete__btn popup-delete__btn-no close-popup">
                                ???? ??????????????!
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
                        ???? ??????????????, ?????? ???????????? ?????????????? ?????????? ?????????????????????
                    </div>
                    <div class="popup-delete__btns">
                        <a class="popup-delete__btn btn" href="?id=666">
                            ????, ??????????????!
                        </a>
                        <a class="popup-delete__btn btn popup-delete__btn-no close-popup">
                            ???? ??????????????!
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
                        ????????
                    </div>
                    <div class="change_popup__items">
                        <div class="change_popup__item">
                            <img src="img/Borsh.png" alt="">
                            <div class="change_popup__status">
                                ?? ????????
                            </div>
                        </div>
                        <div class="change_popup__item">
                            <img src="img/Borsh.png" alt="">
                            <div class="change_popup__status">
                                ?? ????????
                            </div>
                        </div>
                        <div class="change_popup__item">
                            <img src="img/Borsh.png" alt="">
                            <div class="change_popup__status">
                                ?? ????????
                            </div>
                        </div>
                        <div class="change_popup__item">
                            <img src="img/Borsh.png" alt="">
                            <div class="change_popup__status">
                                ?? ????????
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

            workerSearch.oninput = function() {
                let value = this.value.trim().toLowerCase();
                let list = document.querySelectorAll('.workers-list__link');

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