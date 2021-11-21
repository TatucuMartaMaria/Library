<?php
class Book
{
    protected  $id, $title, $author, $genre, $nr_of_pages;
    public $availability = true;

    use addANDdisplay;

    public static function displayBooks()
    {
        echo "<br><b style='color: darkred'>Books:</b><br>";

        (new Book('','',''))->display(get_class(), queryBook(connecttoDB()));
    }

    public static function addBook($title, $author, $genre, $nr_of_pages)
    {
        try {
            $sql = "INSERT INTO books (title, author, genre, nr_of_pages)
  VALUES (:title, :author, :genre, :nr_of_pages)";
            $statement = connecttoDB()->prepare($sql);
            $statement->execute([
                ':title' => $title,
                ':author' => $author,
                ':genre' => $genre,
                ':nr_of_pages' => $nr_of_pages
            ]);
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    }

    public function updateDBBook()
    {
        try {
            $sql = "UPDATE books SET title=:title, author=:author, genre=:genre, nr_of_pages=:nr_of_pages, 
                   availability=:availability WHERE id=$this->id";
            $statement = connecttoDB()->prepare($sql);
            $statement->execute([
                ':title' => $this->title,
                ':author' => $this->author,
                ':genre' => $this->genre,
                ':nr_of_pages' => $this->nr_of_pages,
                ':availability' => $this->availability
            ]);

        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        return $sql;
    }

    public static function displayBooksAvailable($y)
    {
        echo "<br><b style='color: darkred'>Books available:</b><br>";

        foreach($y as $book)
        {
            if($book->availability)
            {
                echo "<pre>";
                print_r($book);
                echo "</pre>";
            }
        }
    }

    public static function searchTheBook($input, $y)
    {
        echo "<br><b style='color: darkred'>Suggestions for the book you searched:</b><br>";

        foreach($y as $book)
        {
            $a = removeSpecialCharacters($book->title);
            $b = removeSpecialCharacters($book->author);
            $c = removeSpecialCharacters($input);

            $condition1 = (similarText($a, $c) >= 50);
            $condition2 = (similarText($b, $c) >= 50);

            if($condition1 || $condition2) {
                echo "<pre>";
                print_r($book);
                echo "</pre>";
            }
        }
    }

    public static function filterBooksByGenre($genre_selected, $x)
    {
        echo "<br><b style='color: darkred'>Books by the genre of {$genre_selected}:</b><br>";

        foreach($x as $book)
        {
            if($book->genre == $genre_selected)
            {
                echo "<pre>";
                print_r($book);
                echo "</pre>";
            }
        }
    }

}



?>