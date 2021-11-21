<?php

class Student extends Customer
{

    protected $faculty, $year_of_study;

    public static function displayStudents()
    {
        echo "<br><b style='color: darkred'>Students:</b><br>";
        foreach(queryCustomer(connecttoDB()) as $item){
            if($item->faculty != '') {
                echo "<pre>";
                print_r($item);
                echo "</pre>";
            }
        }

    }

    public static function addStudent($name,  $faculty, $year_of_study)
    {
        $nr_of_books_borrowed = 0;
        $return_date = '';

        foreach(queryCustomer(connecttoDB()) as $item){
            if($item->name == $name){
                throw new Exception('NumeDejaExistentException');
            }
        }

        try {
            $sql = "INSERT INTO customers (name, nr_of_books_borrowed, return_date, faculty, year_of_study)
        VALUES(:name, :nr_of_books_borrowed, :return_date, :faculty, :year_of_study)";
            $statement = connecttoDB()->prepare($sql);
            $statement->execute([
                ':name' => $name,
                ':nr_of_books_borrowed' => $nr_of_books_borrowed,
                ':return_date' => $return_date,
                ':faculty' => $faculty,
                ':year_of_study' => $year_of_study
            ]);

        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

}

?>