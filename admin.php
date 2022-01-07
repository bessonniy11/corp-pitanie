<?php
require_once __DIR__ . "/database/database.php";

session_start();
if ($_SESSION['admin'] != "admin") {
    header("Location: adminlogin.php");
    exit;
}
if ($_GET['do'] == 'logout') {
    unset($_SESSION['admin']);
    header("Location: adminlogin.php");
    session_destroy();
}


$item1 = $_POST['item1'];
$item2 = $_POST['item2'];
$item3 = $_POST['item3'];
$item4 = $_POST['item4'];
$worker_name = $_POST['worker_name'];
$worker_company = $_POST['worker_company'];
$datefororder = $_POST['datefororder'];

$errors = [];

if (empty($item1)) {
    $errors['item1'] = true;
}
// if (empty($item2)) {
//     $errors['item2'] = true;
// }
// if (empty($item3)) {
//     $errors['item3'] = true;
// }


if (empty($errors)) {
    $sql = "INSERT INTO `orders`(`order_dish1`, `order_dish2`, `order_dish3`, `order_date`, `order_name_worker`, `order_company`, `order_for_date`) VALUES (:order1, :order2, :order3, :order_date, :order_name_worker, :worker_company, :datefororder)";
    $params = [
        "order1" => $item1,
        "order2" => $item2,
        "order3" => $item3,
        "order_date" => $item4,
        "order_name_worker" => $worker_name,
        "datefororder" => $datefororder,
        "worker_company" => $worker_company
    ];

    $dbh->prepare($sql)->execute($params);
    // header("Location: /lk-worker.php");
    // echo "<meta http-equiv=\"refresh\" content=\"0;URL=admin.php\">";
    // header("Refresh:1;");
    // echo $datefororder;
}


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
    $query = "DELETE FROM `companies` WHERE `name` = '$del_company'";
    $dbh->exec($query);
    $query2 = "DELETE FROM `workers` WHERE `worker_company` = '$del_company'";
    $dbh->exec($query2);
    $query3 = "DELETE FROM `company_admins` WHERE `admin_company` = '$del_company'";
    $dbh->exec($query3);
}


$company_id = $_POST['company_id'];
$select_tarif = $_POST['select_tarif'];

$sql = "UPDATE `companies` SET `tarif` = '$select_tarif' WHERE `companies`.`id` = '$company_id'";

$dbh->prepare($sql)->execute($params);


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


$order_dishes1 = [];
$order_dishes2 = [];
$order_dishes3 = [];
// ob_start();

?>

<!DOCTYPE html>
<html lang="ru">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <meta name="description" content="Организуем корпоративное питание. Работаем с НДС. Получите расчет стоимости! · Доставка в удобное время. Работаем более 8 лет. Работаем с НДС. Все способы оплаты. Собственное производство. Свой штат курьеров">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="./img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/profile-style.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <link rel="stylesheet" href="icon.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
</head>


<body>
    <div class="wrapper">
        <div class="admin">
            <div class="admin__title">
                Панель администратора
            </div>
            <div class="admin__body body-admin _tabs">
                <div class="body-admin__sibebar admin-sibebar">
                    <a href="admin.php?do=logout" class="adminlogout">Выйти</a>
                    <div class="admin-sibebar__avatar">
                        <img src="img/corp_logo.png" alt="back">
                    </div>
                    <div class="tabs-block">
                        <div class="tabs-block__item _tabs-item _active">Заказы</div>
                        <div class="tabs-block__item _tabs-item">Компании</div>
                        <div class="tabs-block__item _tabs-item">Меню</div>
                        <div class="tabs-block__item _tabs-item">Статистика</div>
                    </div>
                </div>
                <div class="_tabs-block _active _tabs-block-orders">
                    <div class="orders-header">
                        <button class="refresh-btn">Обновить</button>
                        <div сlass="result__all-wrap">
                            <button class="print__button" onclick="PrintElem('#result')">Печать</button>
                        </div>
                        <?php
                        $company = $_POST['filter'];
                        $dateorders = $_POST['ordersfordate'];
                        ?>
                        <form action="admin.php" method="POST" class="form-orders__admin">
                            <div class="orders-header__calendar">
                                <input class="inputdate" id="inputdate" type="date" name="ordersfordate" value="<?php echo $dateorders ?>">
                            </div>
                            <select type="text" name="filter" id="filter" class="orders-header__select select-orders">
                                <option value="*">Все</option>
                                <?php
                                $sql = "SELECT * FROM `companies`";
                                $rows = $dbh->query($sql);
                                foreach ($rows as $row) {
                                    if ($row['name'] == $company) $selected = " selected";
                                    else $selected = "";
                                ?>
                                    <option value="<?php echo $row['name'] ?>" <? echo $selected; ?>><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                            <button class="select-orders__btn" type="submit">Выбрать</button>
                        </form>
                    </div>
                    <div class="orders__wrapper" id="result">
                        <?php
                        $dateorders1 = date_format($date = date_create($dateorders), 'd.m.Y');

                        if ($company == "*") $sql = "SELECT * FROM `orders` WHERE `order_for_date` = '$dateorders1'";
                        else $sql = "SELECT * FROM `orders` WHERE `order_company` = '$company' AND `order_for_date` = '$dateorders1' ORDER BY `order_id` DESC";

                        $rows = $dbh->query($sql);
                        foreach ($rows as $row) {
                        ?>
                            <div class="order-items">
                                <div class="order-items__header">
                                    <div class="order-items__wrapper">
                                        <div class="order-items__number">Номер заказа: <?php echo $row['order_id'] ?></div>
                                        <div class="order-items__date">Заказ на дату: <span><?php echo $row['order_for_date'] ?></span></div>
                                    </div>
                                    <div class="order-items__wrapper">
                                        <div class="order-items__name"><?php echo $row['order_name_worker'] ?></div>
                                        <div class="order-items__company">Компания: <span><?php echo $row['order_company'] ?></span></div>
                                    </div>
                                </div>
                                <div class="order-items__orders">
                                    <div class="orders-item orders-item-1">Заказ №1: <span class="order1"><?php echo $row['order_dish1'] ?></span></div>
                                    <div class="orders-item orders-item-2">Заказ №2: <span class="order2"><?php echo $row['order_dish2'] ?></span></div>
                                    <div class="orders-item orders-item-3">Заказ №3: <span class="order3"><?php echo $row['order_dish3'] ?></span></div>
                                </div>
                                <div class="order-items__time">Время заказа: <?php echo $row['order_date'] ?></div>
                            </div>
                            <br>
                        <?php
                            $order_dishes1[] = $row['order_dish1'];
                            $order_dishes2[] = $row['order_dish2'];
                            $order_dishes3[] = $row['order_dish3'];
                        }
                        //$content = ob_get_contents();
                        //ob_end_clean();
                        ?>

                        <div class="result__all" id="result__all">
                            <div class="result__all-company"><?php if ($company == "*") echo "Все компании";
                                                                else echo $row['order_company'] ?></div><br>
                            <div class="result__all-view">
                                <div class="result__all-title">Супы:</div>
                                <?php
                                $count_dishes1 = array_count_values($order_dishes1);
                                foreach ($count_dishes1 as $key => $val) if (!empty($key)) echo '<div class="result__all-item">' . $key . ' - ' . $val . ' шт.,</div>';
                                ?>
                            </div><br>
                            <div class="result__all-view">
                                <div class="result__all-title">Салаты:</div>
                                <?php
                                $count_dishes2 = array_count_values($order_dishes2);
                                foreach ($count_dishes2 as $key => $val) if (!empty($key)) echo '<div class="result__all-item">' . $key . ' - ' . $val . ' шт.,</div>';
                                ?>
                            </div><br>
                            <?php //if ($order_dishes3) {
                            ?>
                            <div class="result__all-view">
                                <div class="result__all-title">Гарнир:</div>
                                <?php
                                $count_dishes3 = array_count_values($order_dishes3);
                                foreach ($count_dishes3 as $key => $val) if (!empty($key)) echo '<div class="result__all-item">' . $key . ' - ' . $val . ' шт.,</div>';
                                ?>
                            </div><br>
                            <?php // }
                            ?>

                        </div>
                        <? //= $content 
                        ?>
                    </div>
                </div>
                <div class="_tabs-block _tabs-block-z">
                    <div class="body-admin__btns">
                        <a href="#popup_add_company" class="body-admin__btn body-admin__add-compan popup-link">Добавить компанию +</a>
                        <a href="#popup_add" class="body-admin__btn body-admin__add-compan popup-link">Добавить админа +</a>
                        <!-- <a href="#" class="body-admin__btn body-admin__add-compan popup-link">Фильтр</a> -->
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
                                    <!-- <div class="tarif-company">
                                        <input hidden type="text" name="company_id" class="company_id_change" value="<?php echo $row['id'] ?>">
                                        <select name="select_tarif" id="select_tarif">
                                            <option value="<?php echo $row['tarif'] ?>"><?php echo $row['tarif'] ?></option>
                                            <option value="Стандарт (от 250р)">Стандарт (от 250р)</option>
                                            <option value="Комфорт (от 350р)">Комфорт (от 350р)</option>
                                            <option value="Комфорт (от 350р)">Временно отключить</option>
                                        </select>
                                        <div class="tarif-company__btn btn">Сохранить</div>
                                    </div> -->
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
                <div class="_tabs-block _tabs-block-z">
                    Этот раздел находится в разработке
                </div>
                <div class="_tabs-block _tabs-block-z">
                    Этот раздел находится в разработке
                </div>
            </div>
        </div>
        <div id="popup_add_company" class="popup popup_add_company">
            <div class="popup__body">
                <div class="popup__content">

                    <form action="/admin.php" method="post" class="add-company" enctype="multipart/form-data">
                        <a href="#header" class="popup__close close-popup">
                            <img src="img/close.png" alt="">
                        </a>
                        <input type="text" name="company_name" class="add-company__input" placeholder="Название компании">
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
                            <option value="Мини (от 200р)">Мини (от 200р)</option>
                            <option value="Стандарт (от 250р)">Стандарт (от 250р)</option>
                            <option value="Комфорт (от 350р)">Комфорт (от 350р)</option>
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

                    <form action="/admin.php" method="post" class="add-company">
                        <a href="#header" class="popup__close close-popup">
                            <img src="img/close.png" alt="">
                        </a>
                        <input type="text" name="admin_name" class="add-company__input" placeholder="Имя админа">
                        <select name="company_name" class="add-company__name add-company__input" id="">
                            <?php
                            $sql = "SELECT * FROM `companies`";
                            $rows = $dbh->query($sql);
                            foreach ($rows as $row) {
                            ?>
                                <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
                            <?php } ?>
                        </select>
                        <input type="password" name="admin_password" class="add-company__input" placeholder="Пароль админа">
                        <input type="password" name="admin_pass_confirm" class="add-company__input" placeholder="Подтверждение пароля">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
        <script src="js/izotope.min.js"></script>
        <script src="script.js"></script>
        <script>
            // $(".inputdate").on("change", function() {
            //     this.setAttribute(
            //         "data-date",
            //         moment(this.value, "YYYY-MM-DD")
            //         .format(this.getAttribute("data-date-format"))
            //     )
            // }).trigger("change")

            // $('#inputdatebtn').click(function() {
            //     $.ajax({
            //         method: "POST",
            //         url: "admin.php",
            //         data: {
            //             ordersfordate: $("#inputdate").val()
            //         },
            //         success: function(response) {
            //             console.log($("#inputdate").val())
            //         }
            //     });
            // });

            // $('#filter').change(function() {
            //     $.ajax({
            //         method: "POST",
            //         url: "admin.php",
            //         data: {
            //             filter: $("#filter").val()
            //         },
            //         success: function(response) {
            //             console.log($("#filter").val())
            //         }
            //     });
            // });

            let refreshBtn = document.querySelector('.refresh-btn');
            refreshBtn.addEventListener('click', function() {
                window.location.reload()
            })

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
        <script>
            // const inputdate = document.getElementById('inputdate');
            // window.setInterval(() => {
            //     let date = new Date();

            //     inputdate.value = `${date.getFullYear()}-${(('0' + date.getMonth() + 1)).slice(-2)}-${('0' + (date.getDate() + 1)).slice(-2)}`;

            // }, 1000);
        </script>
        <script type="text/javascript">
            function PrintElem(elem) {
                Popup($(elem).html());
            }

            function Popup(data) {
                var mywindow = window.open('', 'result', 'height=400,width=600');
                mywindow.document.write('<html><head><title style="text-align:start">Заказы</title>');
                mywindow.document.write('</head><body >');
                mywindow.document.write(data);
                mywindow.document.write('</body></html>');
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10
                mywindow.print();
                mywindow.close();
                return true;
            }
        </script>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">

        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/69306538" style="position:absolute; left:-9999px;" alt="" /></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->
</body>

</html>