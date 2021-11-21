<?php

function queryCustomer()
{
    $sql = connecttoDB()->prepare('select * from customers');

    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_CLASS, 'Customer');
}

function queryBook()
{
    $sql = connecttoDB()->prepare('select * from books');

    $sql->execute();

    return $sql->fetchAll(PDO::FETCH_CLASS, 'Book');
}

?>