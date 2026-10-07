<?php
$string = "Twinkle, twinkle, little star";
$array = explode(",", $string);

var_dump($array);
echo "<br>";


// ============================================
$character = "a";

if ($character == "z") {
    echo "a";
} else {
    echo chr(ord($character) + 1);
    echo "<br>";
}
// ============================================
$string = "The brown fox";
$insert = "quick";

$result = substr_replace($string, $insert . " ", 4, 0);

echo $result . "<br>";
// ============================================
$string = "The quick brown fox";

$result = explode(" ", $string);

echo $result[0] . "<br>";
// ============================================


$number = "0000657022.24";

$result = ltrim($number, "0");

echo $result . "<br>";

// ============================================

$string = "The quick brown fox jumps over the lazy dog---";

$result = rtrim($string, "-");

echo $result . "<br>";

// ============================================

$string = "The quick brown fox jumps over the lazy dog";

$words = explode(" ", $string);

$result = array_slice($words, 0, 5);

echo implode(" ", $result) . "<br>";
// ============================================

$number = "2,543.12";

$result = str_replace(",", "", $number);

echo $result . "<br>";

// ============================================
$first = 0;
$second = 1;

for ($i = 0; $i < 9; $i++) {

    echo $first;

    if ($i < 8) {
        echo ", ";
    }

    $next = $first + $second;

    $first = $second;
    $second = $next;
}
echo "<br>";
// ============================================
$sum=1;
for($row=1 ; $row<=5; $row++){
    for($col=0 ; $col<$row; $col++){
        echo $sum++ . " ";
    }
    echo "<br>";
}
// ============================================



echo "<pre>";

for ($i = 1; $i <= 5; $i++) {

    for ($space = 5; $space > $i; $space--) {
        echo " ";
    }

    for ($j = 1; $j <= $i; $j++) {
        echo chr(64 + $j) . " ";
    }

    echo "\n";
}

for ($i = 4; $i >= 1; $i--) {

    for ($space = 5; $space > $i; $space--) {
        echo " ";
    }

    for ($j = 1; $j <= $i; $j++) {
        echo chr(64 + $j) . " ";
    }

    echo "\n";
}

echo "</pre>";



// ============================================
$year = 2013;

if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0)) {
    echo "This year is a leap year <br>";
} else {
    echo "This year is not a leap year <br>";
}
// ============================================
$temperature = 27;

if ($temperature < 20) {
    echo "It is wintertime! <br>";
} else {
    echo "It is summertime! <br>";
}
// ============================================
$firstInteger = 2;
$secondInteger = 2;

$sum = $firstInteger + $secondInteger;

if ($firstInteger == $secondInteger) {
    $sum = $sum * 3;
}

echo $sum . "<br>";

// ============================================
for ($i = 200; $i <= 250; $i++) {

    if ($i % 4 == 0) {
        echo $i . ",";
    }
}
echo "<br>";
// ============================================


$numbers = range(11, 20);

shuffle($numbers);

for ($i = 0; $i < 10; $i++) {
    echo $numbers[$i] . " ";
}

