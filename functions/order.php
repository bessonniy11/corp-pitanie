<?php
require_once __DIR__ . "/database/database.php";




// $item1 = $_POST['item1'];
// $item2 = $_POST['item2'];
// $item3 = $_POST['item3'];
// $item4 = $_POST['item4'];
// $worker_name = $_POST['worker_name'];
// $worker_company = $_POST['worker_company'];
// $datefororder = $_POST['datefororder'];

// $errors = [];

// if (empty($item1)) {
//     $errors['item1'] = true;
// }
// if (empty($item2)) {
//     $errors['item2'] = true;
// }
// if (empty($item3)) {
//     $errors['item3'] = true;
// }



// if (empty($errors)) {
//     $sql = "INSERT INTO `orders`(`order_dish1`, `order_dish2`, `order_dish3`, `order_date`, `order_name_worker`, `order_company`, `order_for_date`) VALUES (:order1, :order2, :order3, :order_date, :order_name_worker, :worker_company, :datefororder)";
//     $params = [
//         "order1" => $item1,
//         "order2" => $item2,
//         "order3" => $item3,
//         "order_date" => $item4,
//         "order_name_worker" => $worker_name,
//         "datefororder" => $datefororder,
//         "worker_company" => $worker_company
//     ];

//     $dbh->prepare($sql)->execute($params);
//     // header("Location: /lk-worker.php");
//     // echo "<meta http-equiv=\"refresh\" content=\"0;URL=admin.php\">";
//     header("Refresh:1; url=admin.php");
//     echo $datefororder;
// }
