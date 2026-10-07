<?php

$colors = array('white', 'green', 'red');

sort($colors);

echo "<ul>";

foreach ($colors as $color) {
    echo "<li>$color</li>";
}

echo "</ul>";

// ============================================

$cities= array( 
    "Italy"=>"Rome",
    "Luxembourg"=>"Luxembourg",
    "Belgium"=> "Brussels",
    "Denmark"=>"Copenhagen",
    "Finland"=>"Helsinki",
    "France" => "Paris",
    "Slovakia"=>"Bratislava",
    "Slovenia"=>"Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens", 
    "Ireland"=>"Dublin",
    "Netherlands"=>"Amsterdam",
    "Portugal"=>"Lisbon",
    "Spain"=>"Madrid"
     );

asort($cities);
foreach($cities as $country => $capital){
echo "The capital of $country is $capital <br>";
} 


// ============================================
$color1 = array (4 => 'white', 6 => 'green', 11=> 'red');
echo $color1[4] . "<br>";
// ============================================
$numbers = [1,2,3,4,5];
array_splice($numbers,3,0,"\$");
echo implode(" ", $numbers) . "<br>";

// ============================================
$fruits = array(
    "d" => "lemon",
    "a" => "orange",
    "b" => "banana",
    "c" => "apple"
    );
asort($fruits);

foreach($fruits as $key => $value){
    echo "$key = $value <br>" ;
}
// ============================================
$temperatures = [
    78, 60, 62, 68, 71, 68, 73, 85, 66, 64,
    76, 63, 75, 76, 73, 68, 62, 73, 72, 65,
    74, 62, 62, 65, 64, 68, 73, 75, 79, 73
];

// Calculate average
$sum = 0;

foreach ($temperatures as $temperature) {
    $sum += $temperature;
}

$average = $sum / count($temperatures);

echo "Average Temperature is: " . $average . "<br>";

// Sort temperatures
sort($temperatures);

// Get five lowest temperatures
$lowest = array_slice($temperatures, 0, 5);

// Get five highest temperatures
$highest = array_slice($temperatures, -5);

echo "List of five lowest temperatures: ";
echo implode(", ", $lowest);

echo "<br>";

echo "List of five highest temperatures: ";
echo implode(", ", $highest)."<br>";
// ============================================
$array1 = array("color" => "red", 2, 4);
$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
$result = array_merge($array1,$array2);
print_r($result ) ;
echo  "<br>";

// ============================================

$colors = array("red", "blue", "white", "yellow");

function upperCase($array) {
    
    foreach ($array as &$color) {
        $color = strtoupper($color);
    }

    return $array;
}

$result1 = upperCase($colors);

print_r($result1);
echo  "<br>";

// ============================================
$num=3;

function isPrime($num){
    $isPrime=true;
    for($i = 2 ; $i < $num ; $i++){
        if($num % $i  == 0){
            $isPrime = false;
            break;
        }
    }
    return $isPrime;
}
if(isPrime($num)){
    echo "the number $num is a prime number . <br>";
}else{
    echo "the number $num is not a prime number . <br>";
}
// ============================================

$string = "remove";

echo strrev($string) . "<br>";
// ============================================


 $x = 12 ;
 $y= 10;

 function swap(&$num1,&$num2){
    $temp=$num1;
    $num1=$num2;
    $num2=$temp;
 }
swap($x,$y);
echo "y = $y <br>";
echo "x = $x <br>";

// ============================================

$num = 407;
function isArmstrong($num){
$sum=0;
$num1=$num;
    while($num != 0){
        $digit= $num % 10;
        $digit = $digit ** 3;
        $sum += $digit ;
        $num=intdiv($num,10);
    }
    if($sum==$num1){
        echo "the number $num1 is a armstrong number <br>";
    }else{
        echo "the number $num1 is not a armstrong number <br>";
    }
}

isArmstrong($num);

// ============================================



$text = "Eva, can I see bees in a cave?";

function isPalindrome($text)
{
    $text = preg_replace("/[^a-zA-Z0-9]/", "", $text);

    $text = strtolower($text);

    $reverse = strrev($text);

    return $text == $reverse;
}

if (isPalindrome($text)) {
    echo "Yes it is a palindrome <br>";
} else {
    echo "No it is not a palindrome <br>";
}
// ============================================

$array1 = array(2, 4, 7, 4, 8, 4);

function removeDuplicates($array)
{
    return array_unique($array);
}

$result = removeDuplicates($array1);

print_r($result);
    echo "<br>";


// ============================================
function is30($num1,$num2){
    if($num1+$num2==30){
        return 30;
    }else{
        return false;
    }
}

if(is30(10,10)){
    echo "the sum of num1 and num2 is 30 <br>";
}else{
    echo "the sum of num1 and num2 is not 30 <br>";
}
// ============================================


$number = 20;

function isMultipleOfThree($number)
{
    if ($number > 0 && $number % 3 == 0) {
        return true;
    }

    return false;
}

$result = isMultipleOfThree($number);

var_dump($result);

echo "<br>";
// ============================================


$number = 50;

function checkRange($number)
{
    if ($number >= 20 && $number <= 50) {
        return true;
    }

    return false;
}

$result = checkRange($number);

var_dump($result);

echo "<br>";
// ============================================


$numbers = [1, 5, 9];

function largestNumber($numbers)
{
    $largest = $numbers[0];

    foreach ($numbers as $number) {
        if ($number > $largest) {
            $largest = $number;
        }
    }

    return $largest;
}

echo largestNumber($numbers);

echo "<br>";


// ============================================


$units = 50;
$bill = 0;

if ($units <= 50) {

    $bill = $units * 2.50;

} elseif ($units <= 150) {

    $bill = (50 * 2.50) + (($units - 50) * 5.00);

} elseif ($units <= 250) {

    $bill = (50 * 2.50) + (100 * 5.00) + (($units - 150) * 6.20);

} else {

    $bill = (50 * 2.50) + (100 * 5.00) + (100 * 6.20) + (($units - 250) * 7.50);

}

echo "Electricity Bill = " . $bill . " JOD <br>";


// ============================================


$num1 = 10;
$num2 = 5;
$operation = "+";

switch ($operation) {

    case "+":
        echo $num1 + $num2 . "<br>";
        break;

    case "-":
        echo $num1 - $num2 . "<br>";
        break;

    case "*":
        echo $num1 * $num2 . "<br>";
        break;

    case "/":
        if ($num2 != 0) {
            echo $num1 / $num2 . "<br>";
        } else {
            echo "Cannot divide by zero <br>";
        }
        break;

    default:
        echo "Invalid operation <br>";
}

// ============================================


$age = 15;

if ($age >= 18) {
    echo "is eligible to vote <br>";
} else {
    echo "is not eligible to vote <br>";
}


// ============================================


$number = -60;

if ($number > 0) {
    echo "Positive <br>";
} elseif ($number < 0) {
    echo "Negative <br>";
} else {
    echo "Zero <br>";
}


// ============================================

$scores = [60, 86, 95, 63, 55, 74, 79, 62, 50];

$sum = 0;

foreach ($scores as $score) {
    $sum += $score;
}

$average = $sum / count($scores);

if ($average <= 100 && $average>=90) {
    $grade = "A";
} elseif ($average <90 && $average>=80) {
    $grade = "B";
} elseif ($average <80 && $average>=70) {
    $grade = "C";
} elseif ($average <70 && $average>=60) {
    $grade = "D";
} else {
    $grade = "F";
}

echo $grade . "<br>";

// ============================================
for ($i = 1; $i <= 10; $i++) {

    echo $i;

    if ($i < 10) {
        echo "-";
    }
}
echo "<br>";
// ============================================

$total = 0;

for ($i = 0; $i <= 30; $i++) {
    $total += $i;
}

echo $total ."<br>" ;


// ============================================

for ($i = 1; $i <= 5; $i++) {

    if ($i == 1) {
        for ($j = 1; $j <= 5; $j++) {
            echo "A";
        }
    }

    elseif ($i == 2) {
        for ($j = 1; $j <= 3; $j++) {
            echo "A";
        }

        for ($j = 1; $j <= 2; $j++) {
            echo "B";
        }
    }

    elseif ($i == 3) {
        for ($j = 1; $j <= 2; $j++) {
            echo "A";
        }

        for ($j = 1; $j <= 3; $j++) {
            echo "C";
        }
    }

    elseif ($i == 4) {
        for ($j = 1; $j <= 2; $j++) {
            echo "A";
        }

        for ($j = 1; $j <= 3; $j++) {
            echo "D";
        }
    }

    else {
        for ($j = 1; $j <= 5; $j++) {
            echo "E";
        }
    }

    echo "<br>";
}

echo "<br>";
// ============================================


for ($i = 1; $i <= 5; $i++) {

    for ($j = 1; $j <= 5; $j++) {

        if ($j <= 5 - $i) {
            echo "1";
        } else {
            echo $i;
        }
    }

    echo "<br>";
}
echo "<br>";

// ============================================
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {
        if($i==$j){
            echo $i;
        }else{
            echo 0;
        }
    }
    echo "<br>";
}
echo "<br>";
// ============================================


$number = 5;
$factorial = 1;

for ($i = 1; $i <= $number; $i++) {
    $factorial = $factorial * $i;
}

echo $factorial;

echo "<br>";
// ============================================


echo "<table border=1>";
for($row=1 ; $row<=6;$row++){
     echo  "<tr>";
    for($col=1 ; $col<=5;$col++){
        echo  "<td> $row" . " * " .  "$col = ". $col * $row ."</td>";
    }
     echo "</tr>";
}

echo "</table>";

// ============================================

$text = "hello world";

// a. Convert the string to uppercase
echo strtoupper($text);
echo "<br>";

// b. Convert the string to lowercase
echo strtolower($text);
echo "<br>";

// c. Make the first letter uppercase
echo ucfirst($text);
echo "<br>";

// d. Make the first letter of each word uppercase
echo ucwords($text);

echo "<br>";
// ============================================

$number = "085119";

for ($i = 0; $i < 6; $i++) {

    echo $number[$i];

    if ($i == 1 || $i == 3) {
        echo ":";
    }
}
echo "<br>";
// ============================================

$sentence = "I am a full stack developer at orange coding academy";
$word = "Orange";

if (strpos(strtolower($sentence), strtolower($word)) !== false) {
    echo "Word Found!";
} else {
    echo "Word Not Found!";
}

echo "<br>";

// ============================================


$url = "www.orange.com/index.php";

echo basename($url);

// ============================================


$email = "info@orange.com";

$result = explode("@", $email);

echo $result[0];
echo "<br>";
// ============================================

$string = "info@orange.com";

echo substr($string, -3);

echo "<br>";

// ============================================


$characters = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

$password = "";

for ($i = 0; $i < 7; $i++) {
    $index = random_int(0, strlen($characters) - 1);
    $password .= $characters[$index];
}

echo $password;
echo "<br>";

// ============================================


$sentence = "Thet new trainee is so genius.";
$newWord = "Our";

$result = $newWord . substr($sentence, strpos($sentence, " "));

echo $result;

// ============================================





// ============================================
