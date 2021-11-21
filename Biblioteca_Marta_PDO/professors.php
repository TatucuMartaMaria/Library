<?php

class Professor extends Customer
{
    protected $course_taught;

    public static function addProfessor($name,  $course_taught)
    {
        $nr_of_books_borrowed = 0;
        $return_date = '';

        foreach(queryCustomer(connecttoDB()) as $item){
            if($item->name == $name){
                throw new Exception('NumeDejaExistentException');
            }
        }

        try {
            $sql = "INSERT INTO customers (name, nr_of_books_borrowed, return_date, course_taught)
        VALUES(:name, :nr_of_books_borrowed, :return_date, :course_taught)";
            $statement = connecttoDB()->prepare($sql);
            $statement->execute([
                ':name' => $name,
                ':nr_of_books_borrowed' => $nr_of_books_borrowed,
                ':return_date' => $return_date,
                ':course_taught' => $course_taught
            ]);

        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

}


?>