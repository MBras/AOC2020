<?php

$lines =  file("input");

function seatid($code) {
    $search = array("F", "B", "L", "R");
    $replace = array(0, 1, 0, 1);
    return intval(str_replace($search, $replace, $code), 2);
}

echo seatid("BBFFBBFRLL") . "<br>";
echo seatid("FFFBBBFRRR") . "<br>";

$max = 0;
$seats = array();

foreach ($lines as $line) {
    $max = max($max, seatid($line));
    $seats[] = seatid($line);
}

echo $max . "<br>";

echo "==== Part 2 ====<br>";
array_multisort($seats);

for ($x = 0; $x < sizeof($seats) - 1; $x++) {
    if (($seats[$x + 1] - $seats[$x]) == 2) {
        echo "Seat id " . ($seats[$x] + 1) . " found at " . $x . "!<br/>";
    }
}
