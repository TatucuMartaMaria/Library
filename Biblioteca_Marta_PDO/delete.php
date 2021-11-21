<?php


function deleteBook($id)
{
    try {
        $sql = "DELETE FROM books WHERE id=$id";
        connecttoDB()->exec($sql);
        
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    return $sql;
}

function deleteCustomer($id)
{
    try {
        $sql = "DELETE FROM customers WHERE id=$id";
        connecttoDB()->exec($sql);
        
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    return $sql;
}






?>