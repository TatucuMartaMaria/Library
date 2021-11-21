<?php

require 'requires.php';

$pdo = connecttoDB();


$x = queryCustomer();
$y = queryBook();

Customer::displayCustomers();
Customer::theMostFaithfulReader();
Book::displayBooks();

$z = queryCustomer($pdo)[2];
var_dump($z);

$w = queryBook($pdo)[0];
var_dump($w);

$z->borrowTheBook($w);

$z->hasPenalties();

//$z->returnTheBook($w);

Book::displayBooksAvailable($y);
Book::searchTheBook('Inteligen',$y);

Book::filterBooksByGenre('Dezvoltare personala',$y);



//Book::addBook('Idiotul','F.M. Dostoievski','beletristica','528');
//Student::addStudent('Petre Maria', 'Arhitectura', 3);
//Professor::addProfessor('Anghel Marina', 'Matematica' );

Student::displayStudents();

//deleteCustomer(19);
//deleteBook(18);

?>