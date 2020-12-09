<?php

$lines =  file("input");

$preamble = 25;

function check($numbers, $value) {
    for ($x = 0; $x < sizeof($numbers) - 1; $x++) {
        for ($y = 1; $y < sizeof($numbers); $y++) {
            if ($numbers[$x] + $numbers[$y] == $value) 
                return true;
        }
    }
    return false;;
}

$part1 = 0;
for ($x = $preamble; $x < sizeof($lines); $x++) {
    if (check(array_slice($lines, $x - $preamble, $preamble), $lines[$x])) {
//        echo "Ok<br>";
    } else {
        echo "Part 1 --- Not ok: " . $lines[$x] . "<br>";
        $part1 = $lines[$x];
    }
}

//----- part 2
for ($x = 0; $x < sizeof($lines); $x++) {
    $min = $lines[$x];
    $max = $lines[$x];
    $counter = $x;
    $sum = 0;
    while ($sum <= $part1) {
        $sum += $lines[$counter];
        $min = min($min, $lines[$counter]);
        $max = max($max, $lines[$counter]);

        //echo $sum . "<br>";
        if ($sum == $part1) {
            echo "Part 2: " . ($min + $max) . "<br>";
        }
        $counter++;
    }
    //echo "next <br>";
}

