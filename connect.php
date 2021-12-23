<?php
function getDbConnect()
{
    //name severname:
    $hostname = 'db';

    //username to access the database of mysql
    $username = 'trangg';

    //password of username
    $password = 'trangk';

    //Access database name.
    $dbname = 'trangg';
    //create object and link PDO
    return new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8", $username, $password);
}

function executeQuery($sqlQuery, $fetchAll = true)
{
    $connect = getDbConnect();
    $stmt = $connect->prepare($sqlQuery);
    $stmt->execute();

    if ($fetchAll == true) {
        return $stmt->fetchAll();
    }
    return $stmt->fetch();
}
