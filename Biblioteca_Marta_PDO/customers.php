<?php

class Customer
{
    protected $id, $name, $nr_of_books_borrowed, $return_date;

    use addANDdisplay;


    public static function displayCustomers()
    {
        echo "<br><b style='color: darkred'>Customers:</b><br>";

        (new Customer(''))->display(get_class(), queryCustomer(connecttoDB()));
    }

    public static function updateDBCustomer($id, $name, $nr_of_books_borrowed, $return_date)
    {
        try {
            $sql = "UPDATE customers SET name=:name, nr_of_books_borrowed=:nr_of_books_borrowed, 
                   return_date=:return_date WHERE id=$id";
            $statement= connecttoDB()->prepare($sql);
            $statement->execute([
                ':name' => $name,
                ':nr_of_books_borrowed' => $nr_of_books_borrowed,
                ':return_date' => $return_date
            ]);

        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        return $sql;
    }

    public static function theMostFaithfulReader()
    {
        echo "<br><b style='color: darkred'>The most faithful reader is:</b><br>";

        $max = 0;
        foreach(queryCustomer(connecttoDB()) as $item) {
            foreach (queryCustomer(connecttoDB()) as $customer) {
                $max = ($customer->nr_of_books_borrowed > $max) ? $customer->nr_of_books_borrowed : $max;;

            }
            if ($item->nr_of_books_borrowed == $max) {
                echo "<pre>";
                print_r($item);
                echo "</pre>";
            }
        }
    }

    public function borrowTheBook($book)
    {
        if($book->availability == false)
        {
            throw new Exception('BookUnavailableException');
        }

        try{
            if(empty($this->return_date))
            {
                echo "<br><b style='color: darkred'>The book was borrowed.</b><br>";
                $this->nr_of_books_borrowed++;
                $book->availability = false;
                date_default_timezone_set("Europe/Bucharest");
                $this->return_date = date("d/m/Y", strtotime("+2 weeks"));

                Customer::updateDBCustomer($this->id, $this->name, $this->nr_of_books_borrowed, $this->return_date);
                $book->updateDBBook();

            }else{
                echo "<br><b style='color: red'>Only one book can be borrowed!
                                     You will be able to borrow a new book when you return the first book.</b><br>";
            }

        }catch(Exception $e){
            echo $e->getMessage(), "\n";
        }
    }


    public function returnTheBook($book)
    {
        $book->availability = true;
        $this->return_date = null;
        Customer:: updateDBCustomer($this->id, $this->name, $this->nr_of_books_borrowed, $this->return_date);
        $book->updateDBBook();
    }

    public function hasPenalties()
    {
        if(empty($this->return_date))
        {
            echo "<br><b style='color: green'>Hasn't penalties.</b><br>";
        }else{
            date_default_timezone_set("Europe/Bucharest");
            $a = convertDateInToNr($this->return_date);
            $b = convertDateInToNr(date('d/m/Y'));

            if($a < $b)
            {
                echo "<br><b style='color: red'>PENALTY!!!The customer must return the book.</b><br>";
            }
        }

    }

}


?>