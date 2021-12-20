<?php

function generateToken(
    int $length = 64,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
): string {
    if ($length < 1) {
        throw new \RangeException("Length must be a positive integer");
    }
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces[] = $keyspace[rand(0, $max)];
    }
    return implode('', $pieces);
}

function updateAdminToken($dbh, $adminId, $token): void
{
    $sql = "UPDATE `company_admins` SET `admin_token` = :token WHERE `admin_id` = $adminId";
    $params = ["token" => $token];
    $dbh->prepare($sql)->execute($params);
}

function updateWorkerToken($dbh, $workerId, $token): void
{
    $sql = "UPDATE `workers` SET `worker_token` = :token WHERE `worker_id` = $workerId";
    $params = ["token" => $token];
    $dbh->prepare($sql)->execute($params);
}

function fetchAdminByToken($dbh, $token)
{
    $sql = "SELECT * FROM `company_admins` WHERE `admin_token` = :token";
    $params = ["token" => $token];
    $fetchAdmin = $dbh->prepare($sql);
    $fetchAdmin->execute($params);
    return $fetchAdmin->fetch(PDO::FETCH_ASSOC);
}
function fetchWorkerByToken($dbh, $token)
{
    $sql = "SELECT * FROM `workers` WHERE `worker_token` = :token";
    $params = ["token" => $token];
    $fetchAdmin = $dbh->prepare($sql);
    $fetchAdmin->execute($params);
    return $fetchAdmin->fetch(PDO::FETCH_ASSOC);
}
