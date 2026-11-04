<?php
class Student {

public $name;
public $age;
public $grade;

public function __construct($name,$grade,$age=18){
    $this->name=$name;
    $this->age=$age;
    $this->updateGrade($grade);
}

public function displayInfo(){
    echo "student's name : $this->name
      <br>student's age : $this->age
      <br>student's grade : $this->grade <br>";
}

public function isPassed(){
    if($this->grade >= 50){
        return true;
        }else{
        return false;
        }
}

public function updateGrade($newGrade){
    if($newGrade >=0 && $newGrade <=100)
        $this->grade = $newGrade;
    else 
        echo "error <br>";
}

public function getLetterGrade() {
if($this->grade <= 100 && $this->grade>=90)
    return "A <br>";
else if($this->grade < 90 && $this->grade>=80)
    return "B <br>";
else if($this->grade < 80 && $this->grade>=70)
    return "C <br>";
else if($this->grade < 70 && $this->grade>=60)
    return "D <br>";
else
    return "F <br>";
}
}

$students=[
new Student("Mohammad",99,22),
new Student("Ahmad",85,21),
new Student("Omar",40)
];


foreach($students as $student){
    $student->displayInfo();

    if($student->isPassed())
        echo "The student $student->name is passed <br>";
    else 
        echo "The student $student->name is not passed <br>";

    echo $student->name . "'s LetterGrade is " . $student->getLetterGrade(). "<br>";
}
?>