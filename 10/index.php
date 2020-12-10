<?php

$lines = array_map('intval', file("input.prod"));
sort($lines);

$diffs = array(0,1,0,1);
for ($x = 0; $x < sizeof($lines) - 1; $x++) {
    $diffs[$lines[$x + 1] - $lines[$x]]++;
}
echo "Part 1: ". ($diffs[1] * $diffs[3]) . "<br>";

