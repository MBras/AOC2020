<?php

$lines =  file("input.prod");

$lines = array_map('intval', $lines);
sort($lines);
//print_r($lines);

$diffs = array(0,1,0,1);
for ($x = 0; $x < sizeof($lines) - 1; $x++) {
    $diffs[$lines[$x + 1] - $lines[$x]]++;
}
//print_r($diffs);
echo "Part 1: ". ($diffs[1] * $diffs[3]) . "<br>";

