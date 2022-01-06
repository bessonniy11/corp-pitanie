<?php

require_once __DIR__ . "/database/database.php";

$sql = "SELECT * FROM `orders` ORDER BY `order_date` DESC";
$rows = $dbh->query($sql);
foreach ($rows as $row) {
?>
    <div class="order-items <?php echo $row['order_company'] ?>">
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
            <div class="order-items__orders-item">Заказ №1: <span><?php echo $row['order_dish1'] ?></span></div>
            <div class="order-items__orders-item">Заказ №2: <span><?php echo $row['order_dish2'] ?></span></div>
            <div class="order-items__orders-item">Заказ №3: <span><?php echo $row['order_dish3'] ?></span></div>
        </div>
        <div class="order-items__time">Время заказа: <?php echo $row['order_date'] ?></div>
    </div>
<?php } ?>