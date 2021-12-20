<?php
require_once __DIR__ . "/database/database.php";


if (isset($_POST['reg_admin_submit'])) {
    $admin_name = $_POST['admin_name'];
    $company_name = $_POST['company_name'];
    $admin_password = $_POST['admin_password'];
    $admin_pass_confirm = $_POST['admin_pass_confirm'];

    $errors = [];

    if (empty($admin_name)) {
        $errors['admin_name'] = true;
    }
    if (empty($admin_password) || empty($admin_pass_confirm) || $admin_password != $admin_pass_confirm) {
        $errors['$admin_password'] = true;
    }

    if (empty($errors)) {
        $sql = "INSERT INTO `company_admins`(`admin_name`, `admin_company`, `admin_password`) VALUES (:admin_name, :admin_company, :admin_password)";
        $params = [
            "admin_name" => $admin_name,
            "admin_company" => $company_name,
            "admin_password" => password_hash($admin_password, PASSWORD_DEFAULT)
        ];

        $dbh->prepare($sql)->execute($params);
        header("Location: /admin.php");
    }
}

if (isset($_POST['del_company_btn'])) {
    $del_company = $_POST['del_company'];
    $del_id = $_POST['del_id'];

    // echo $del_company;
    $query = "DELETE FROM `companies` WHERE `id` = $del_id";
    $dbh->exec($query);
}

// if (isset($_GET['id'])) {
//     $id = ($_GET['id']);

//     $query = "DELETE FROM `companies` WHERE `id` = $id";
//     $dbh->exec($query);


//     header("Location: /admin.php");
// }



if (isset($_POST['reg_company_submit'])) {
    $company_name = $_POST['company_name'];
    $company_img = $_POST['company_img'];
    $company_tarif = $_POST['company_tarif'];

    $name = $_FILES['company_img']['name'];
    $tmp_name = $_FILES['company_img']['tmp_name'];

    move_uploaded_file($tmp_name, "img/companies/" . $name);


    $sql = "INSERT INTO `companies` (`name`, `img`, `tarif`) VALUES (:name, :img, :tarif)";
    $params = [
        "name" => $company_name,
        "img" => $name,
        "tarif" => $company_tarif
    ];

    $dbh->prepare($sql)->execute($params);
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
    <link rel="icon" href="./img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profile-style.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="icon.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- </head>
<style>
    .label-create-img {
        position: absolute;
        border: 1px solid black;
        width: 40px;
        height: 40px;
        left: 50%;
        top: 20%;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translate(-50%, -50%);
        font-size: 52px;
        text-align: center;
        cursor: pointer;
        border-radius: 50%;
        color: #fff;
        background-color: #777c99;
        -webkit-transition: background-color 0.3s ease 0s;
        -o-transition: background-color 0.3s ease 0s;
        transition: background-color 0.3s ease 0s;
    }

    .label-create-img:hover {
        background-color: #61678f;
    }

    .change-img__title {
        z-index: 10;
        font-weight: 800;
        text-shadow: 0 0 5px 0 #fff;
        margin-top: -80px;
        position: absolute;
        bottom: 10px;
        left: 0;
        width: 100%;
    }

    .change_img-input {
        display: none;
    }

    ._tabs-block {
        display: none;
        margin: 0 20px;
    }

    ._tabs-block._active {
        display: block;
    }

    .tabs-block__item {
        font-family: 'sf-regular', sans-serif;
        border-radius: 20px;
        padding: 8px 15px;
        font-size: 14px;
        margin: 20px auto;
        font-weight: 400;
        color: #000;
        display: flex;
        cursor: pointer;
        justify-content: start;
    }

    .tabs-block__item._active {
        background-color: #fff;
        /* background-color: cadetblue; */
        /* color: #fff; */
        box-shadow: 0 0 3px 0 rgba(34, 60, 80, 0.980);
    }

    .tabs-block__item:hover {
        /* border-radius: 20px;
    background-color: rgba(95, 158, 160, 0.5);
    color: #fff; */
        box-shadow: 0 0 3px 0 rgba(34, 60, 80, 0.780);
    }

    .side-bar__items {}

    .tabs-block {}

    .tabs-block__item {}

    ._tabs-item {}

    ._active {}

    .tabs-body {
        width: 100%;
        min-height: 100vh;
        position: relative;
    }

    ._tabs-block {
        margin-top: 40px;
    }

    .add-company {
        display: block;
        max-width: 250px;
        position: absolute;
        left: 50%;
        top: 30%;
        transform: translate(-50%, -50%);
        padding: 20px;
        border: 2px solid #000
    }

    .add-company__name {
        padding: 3px 10px;
        width: 100%;
        margin-bottom: 20px;
    }

    .add-company__img {
        padding: 3px 10px;
        width: 100%;
        margin-bottom: 20px;
        display: none;
    }

    .add-company__tarif {
        padding: 3px 10px;
        width: 100%;
        margin-bottom: 20px;
    }

    .add-company__btn {
        padding: 10px 20px;
        border: 2px solid #484848;
        color: #484848;
        border-radius: 20px;
        display: block;
        text-align: center;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease 0s;
    }

    .add-company__btn:hover {
        border: 2px solid #484848;
        color: #fff;
        background: #484848;
    }

    .main__item--img--create {
        position: relative;
        min-height: 150px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .delete-style {
        min-width: 400px;
        /* max-width: 320px; */
        padding: 10px 10px 18px;
    }

    .popup-delete {
        position: relative;
        background-color: rgb(255, 93, 102);
        /*top: 30%;*/
        /*left: 30%;*/
        margin: 0 auto;
        display: block;
        min-height: 140px;
        max-width: 200px;
        align-items: center;
        text-align: center;
        border-radius: 10px;
        opacity: 0;
        transform: translate(0px, -100%);
        transition: all 0.6s ease;
    }

    .popup.open .popup-delete {
        transform: perspective(600px)translate(0px, 0%) rotateX(0deg);
        opacity: 1;
    }

    .popup-delete__title {
        padding: 30px 20px 0;
        text-align: center;
        /*overflow-x:hidden;*/
        word-wrap: break-word;
        width: 100%;
    }

    .popup-delete__btns {
        margin-top: 30px;
        display: flex;
        justify-content: space-around;
        width: 100%;
    }

    .popup-delete__btn {
        background-color: #777c99;
        font-size: 17px;
        padding: 5px 10px;
        color: #fff;
        border: 1px solid #000;
        display: inline-block;
        /*margin: 0 auto 20px;*/
        /* max-width: 130px; */
        align-items: center;
        text-align: center;
        -webkit-transition: background-color 0.3s ease 0s;
        -o-transition: background-color 0.3s ease 0s;
        transition: background-color 0.3s ease 0s;
        cursor: pointer;
    }

    .popup-delete__btn:hover {
        background-color: #F92453;
        color: #fff;
    }

    .popup-delete__btn-no:hover {
        background-color: #61678f;
    }
</style> -->

<body>
    <div class="wrapper">
        <div class="admin">
            <div class="admin__title">
                Панель администратора
            </div>
            <div class="admin__body body-admin _tabs">
                <div class="body-admin__sibebar admin-sibebar">
                    <div class="admin-sibebar__avatar">
                        <img src="img/corp_logo.png" alt="back">
                    </div>
                    <div class="tabs-block">
                        <div class="tabs-block__item _tabs-item">Заказы</div>
                        <div class="tabs-block__item _tabs-item _active">Компании</div>
                        <div class="tabs-block__item _tabs-item">Меню</div>
                        <div class="tabs-block__item _tabs-item">Статистика</div>
                    </div>
                </div>
                <div class="_tabs-block ">
                    <?php
                    $sql = "SELECT * FROM `orders` ORDER BY `order_date` DESC";
                    $rows = $dbh->query($sql);
                    foreach ($rows as $row) {
                    ?>
                        <div class="order-items">
                            <div><?php echo $row['order_name_worker'] ?></div>
                            <div><?php echo $row['order_company'] ?></div><br>
                            <div><?php echo $row['order_dish1'] ?></div>
                            <div><?php echo $row['order_dish2'] ?></div>
                            <div><?php echo $row['order_dish3'] ?></div><br>
                            <div><?php echo $row['order_date'] ?></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="_tabs-block _active">
                    <div class="body-admin__btns">
                        <a href="#popup_add_company" class="body-admin__btn body-admin__add-compan popup-link">Добавить компанию +</a>
                        <a href="#popup_add" class="body-admin__btn body-admin__add-compan popup-link">Добавить админа +</a>
                        <a href="#" class="body-admin__btn body-admin__add-compan popup-link">Фильтр</a>
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
                            <div data-name="<?php echo $row['name'] ?>" class="profile-company-wrapper">
                                <div class="profile-company">
                                    <div class="profile-company__img _ibg">
                                        <img src="img/companies/<?php echo $row['img'] ?>" alt="">
                                    </div>
                                    <div class="profile-company__body">
                                        <div class="profile-company__title">
                                            <?php echo $row['name'] ?>
                                        </div>
                                        <a href="<?php echo $row['name'] ?>" class="profile-company__btn btn popup-link">
                                            Удалить
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="_tabs-block">
                    3
                </div>
                <div class="_tabs-block">
                    4
                </div>
            </div>
        </div>
        <!-- </div> -->
        <div id="popup_add_company" class="popup popup_add_company">
            <div class="popup__body">
                <div class="popup__content">
                    <a href="#header" class="popup__close close-popup">
                        <img src="img/close.png" alt="">
                    </a>
                    <form action="/admin.php" method="post" class="add-company" enctype="multipart/form-data">
                        <input type="text" name="company_name" class="add-company__input" placeholder="название компании">
                        <input type="text" name="company_img" class="add-company__img">
                        <div class="main__item--img--create _ibg">
                            <div class="imagePreview" id="imagePreview">
                                <img class="tabs-img change-img__image edit_change-img__image">
                            </div>
                            <span class="change-img__title">Выберите фото</span>
                            <label class="label-create-img" for="change_img-input">+</label>
                            <input class="add-company__img" id="change_img-input" type="file" name="company_img" alt="">
                        </div>
                        <select name="company_tarif" size=1 class="add-company__tarif">
                            <option value="1">Тариф №1</option>
                            <option value="2">Тариф №2</option>
                            <option value="3">Тариф №3</option>
                        </select>
                        <button type="submit" name="reg_company_submit" class="add-company__btn">
                            Добавить
                        </button>
                    </form>
                </div>
            </div>
        </div>


        <div id="popup_add" class="popup popup_add">
            <div class="popup__body">
                <div class="popup__content">
                    <a href="#header" class="popup__close close-popup">
                        <img src="img/close.png" alt="">
                    </a>
                    <form action="/admin.php" method="post" class="add-company">
                        <input type="text" name="admin_name" class="add-company__input" placeholder="имя админа">
                        <select name="company_name" class="add-company__name add-company__input" id="">
                            <?php
                            $sql = "SELECT * FROM `companies`";
                            $rows = $dbh->query($sql);
                            foreach ($rows as $row) {
                            ?>
                                <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                            <?php } ?>
                        </select>
                        <input type="password" name="admin_password" class="add-company__input" placeholder="пароль админа">
                        <input type="password" name="admin_pass_confirm" class="add-company__input" placeholder="подтверждение пароля">
                        <button type="submit" name="reg_admin_submit" class="add-company__btn">
                            Добавить
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php
        $sql = "SELECT * FROM `companies`";
        $rows = $dbh->query($sql);
        foreach ($rows as $row) {
        ?>
            <div id="<?php echo $row['name'] ?>" class="popup popup_add">
                <form class="popup__body" action="admin.php" method="POST">
                    <div class="popup__content delete-style">
                        <div class="popup__close _icon-close"></div>
                        <div class="popup-delete__title ">
                            Вы уверены, что хотите удалить <?php echo $row['name'] ?>?
                        </div>
                        <input hidden type="text" name="del_company" value="<?php echo $row['name'] ?>">
                        <input hidden type="text" name="del_id" value="<?php echo $row['id'] ?>">
                        <div class="popup-delete__btns">
                            <button class="popup-delete__btn" type="submit" name="del_company_btn">
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script src="script.js"></script>
        <script>
            // search


            window.onload = () => {
                let input = document.querySelector('.profile-searche__input');
                let hrefAttr = document.querySelector('.profile-company-wrapper');
                // let profileComp = document.querySelectorAll('.profile-company');
                // console.log(hrefAttr.getAttribute('href').replace('#', ''));


                input.oninput = function() {
                    let value = this.value.trim().toLowerCase();
                    let list = document.querySelectorAll('.profile-company-wrapper');
                    let listtitle = document.querySelectorAll('.profile-company__title');

                    if (value != '') {
                        list.forEach(elem => {
                            if (elem.getAttribute('data-name').toLowerCase().search(value) == -1) {
                                elem.classList.add('hide');

                            } else {
                                list.forEach(elem => {
                                    elem.classList.remove('hide');
                                });
                            }
                        });
                    }
                };
            };
            //IMAGE_PREVIEW

            const inpFile = document.getElementById('change_img-input');
            const previewContainer = document.getElementById('imagePreview');
            const previewImage = previewContainer.querySelector('.change-img__image');
            const previewDefaultText = document.querySelector('.change-img__title');

            if (previewImage) {
                inpFile.addEventListener("change", function() {
                    const file = this.files[0];

                    if (file) {
                        const reader = new FileReader();
                        previewDefaultText.style.display = "none";
                        previewContainer.style.display = "block";

                        reader.addEventListener("load", function() {
                            previewImage.setAttribute("src", this.result);
                        });
                        reader.readAsDataURL(file);

                    } else {
                        previewDefaultText.style.display = null;
                        previewContainer.style.display = null;
                        previewImage.setAttribute("src", "");
                    }

                });
            }
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