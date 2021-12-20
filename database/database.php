<?php
try {
    $dbh = new PDO('mysql:host=localhost;dbname=corp_db', "root", "");
} catch (\Exception $exception) {
    echo "Ошибка при подключеии БД <br>";
    echo $exception->getMessage();
    die();
}
