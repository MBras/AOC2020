<?php

$lines =  file("input.mb");

$lines = array_map('intval', $lines);
sort($lines);
//print_r($lines);

$diffs = array(0,1,0,1);
for ($x = 0; $x < sizeof($lines) - 1; $x++) {
    $diffs[$lines[$x + 1] - $lines[$x]]++;
}
//print_r($diffs);
echo "Part 1: ". ($diffs[1] * $diffs[3]) . "<br>";

echo "=========[ Part 2 ]============<br>";

function pa($a) {
    for ($x = 0; $x <= sizeof($a); $x++) {
        if ($x == 0) {
            echo "(" . $a[0] . "), ";
        } elseif ($x == sizeof($a)) {
            echo "(" . ($a[$x - 1] + 3) . ")<br>";
        } else {
            echo $a[$x] . ", ";
        }
    }
}

$counter = 0;

function adapt($prev, $remainder, $lastval) {
//    echo "Adapting from " . $lastval . "<br>";
    global $counter;
    if (sizeof($remainder) == 0) {
        //print_r($prev);
        //pa($prev);
        $counter++;
        //if ($counter % 1000 == 0) echo ".";
    }
    for ($x = 0; $x < min(sizeof($remainder), 3); $x++) {
        if (($remainder[$x] - $lastval) <= 3) {
            //echo "Found " . $remainder[$x] . "<br>";
            $newprev = $prev;
            $val = $remainder[$x];
            $newprev[] = $remainder[$x];
            adapt($newprev, array_slice($remainder, $x + 1), $val);
        } else {
            return 1;
        }
    }
}

$sequence[] = 0;
adapt($sequence, $lines, 0);

print_r($lines);
echo "Part 2: " . $counter ."<br>";

function adapt2($index) {
    global $lines;
    
    $sum = 0;
    for ($x = $index + 1; $x <= $index + 3; $x++) {
        //echo "Checking " . $index . " vs. " . $x . "<br>";
        if ($x < sizeof($lines) - 1) {
            if ($lines[$x] - $lines[$index] <= 3) {
                $sum += adapt2($x);
            }
        } else {
            if ($lines[$x] - $lines[$index] <= 3) {
                return max(1, $sum);
            } else {
                return $sum;
            }
        }
    }
    return $sum;
}

echo "Part 2: " . adapt2(0);// toch recursief :/
