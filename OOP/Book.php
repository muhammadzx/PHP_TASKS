<?php

class Book{
public $author;
public $title;

public function __construct($author,$title){
    $this->author=$author;
    $this->title=$title;
    echo "Book created ... " . "<br>";
}

public function displayInfo(){
    echo "Book information :" . "<br>" .
    "Author : $this->author" . "<br>" .
    "Book title : $this->title" . "<br>";
}

public function __destruct(){
    echo "Book destroyed: ..." . "<br>";
}
}


$book1 = new Book("MOHAMMAD","PHP basecs");
$book1->displayInfo();

$book2 = new Book("AHMAD","JS basecs");
$book2->displayInfo();
unset($book2);
$book3 =$book1 ;
unset($book1);
$book3->displayInfo();

?>