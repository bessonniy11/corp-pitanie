<?php
require_once __DIR__ . "/database/database.php";


$item1 = $_POST['item1'];
$worker_name = $_POST['worker_name'];
$worker_company = $_POST['worker_company'];


$errors = [];

if (empty($item1)) {
    $errors['item1'] = true;
}


if (empty($errors)) {
    $sql = "INSERT INTO `orders`(`order_dish1`, `order_name_worker`, `order_company`) VALUES (:order1, :order_name_worker, :worker_company)";
    $params = [
        "order1" => $item1,
        "order_name_worker" => $worker_name,
        "worker_company" => $worker_company
    ];

    $dbh->prepare($sql)->execute($params);
}
$order_dishes1 = [];


?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Document</title>
</head>

<body>

    <select type="text" name="filter" id="filter">
        <option value="*">All</option>
        <?php
        $sql = "SELECT * FROM `companies`";
        $rows = $dbh->query($sql);
        foreach ($rows as $row) {
        ?>
            <option value="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></option>
        <?php } ?>
    </select>



    <div class="orders__wrapper" id="result">
        <?php
        $company = $_POST['filter'];
        var_dump($_POST['filter']);
        $sql = "SELECT * FROM `orders` WHERE `order_company` = '$company'";
        $rows = $dbh->query($sql);
        foreach ($rows as $row) {
        ?>
            <div class="order-items <?php echo $row['order_company'] ?>">
                <div class="order-items__header">
                    <div class="order-items__wrapper">
                        <div class="order-items__number">Order №: <?php echo $row['order_id'] ?></div>
                    </div>
                    <div class="order-items__wrapper">
                        <div class="order-items__name"><?php echo $row['order_name_worker'] ?></div>
                        <div class="order-items__company">Company: <span><?php echo $row['order_company'] ?></span></div>
                    </div>
                </div>
                <div class="order-items__orders">
                    <div class="orders-item orders-item-1">Order №1: <span class="order1"><?php echo $row['order_dish1'] ?></span></div>
                </div>
            </div>
        <?php
            $order_dishes1[] = $row['order_dish1'];
        }
        $content = ob_get_contents();
        ob_end_clean();
        ?>

        <div class="result__all" id="result__all">
            <div class="result__all-company"><?php echo $row['order_company'] ?></div><br>
            <div class="result__all__wrapper">
                <div class="result__all-view">
                    <div class="result__all-title">Soups:</div>
                    <?php
                    $count_dishes1 = array_count_values($order_dishes1);
                    foreach ($count_dishes1 as $key => $val) echo '<div class="result__all-item">' . $key . ' - ' . $val . ' шт.,</div>';
                    ?>
                </div><br>
            </div>
        </div>
        <?= $content ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $('#filter').change(function() {
            $.ajax({
                method: "POST",
                url: "test.php",
                data: {
                    filter: $("#filter").val()
                },
                success: function(response) {
                    console.log($("#filter").val())

                }
            });
        });
    </script>
</body>

</html>