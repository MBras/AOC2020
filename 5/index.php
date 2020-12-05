<?php

$lines =  file("input");

function seatid($code) {
    $front = 0;
    $back = 127;
    
    $left = 0;
    $right = 7;

    foreach (str_split($code) as $char) {
        switch ($char) {
            case 'F':
                // lower half
                $back = ($front + $back - 1) / 2;
                break;
            case 'B':
                // upper half
                $front = ($front + $back + 1) / 2;
                break;
            case 'L':
                // lower half
                $right = ($right + $left - 1) / 2;
                break;
            case 'R':
                // upper half
                $left = ($right + $left + 1) / 2;
                break;
        }
    }
    return $front * 8 + $left;
}

//echo seatid("BBFFBBFRLL") . "<br>";
//echo seatid("FFFBBBFRRR") . "<br>";

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
