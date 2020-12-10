<?php

$lines =  file("input.prod");

$lines = array_map('intval', $lines);
sort($lines);
array_unshift($lines, 0);

$sum = array(1);
for ($x = 1; $x < sizeof($lines); $x++) {
    //check van alles wat voorafgaand in range is hoeveel stappen er naartoe gemaakt kunnen worden en tel die op
    $tempsum = 0;
    for ($y = max(0, $x - 3); $y < $x; $y++) {
        if (($lines[$x] - $lines[$y]) <= 3) {
            $tempsum += $sum[$y];
        }
    }
    $sum[] = $tempsum;
}
echo "Part 2: " . array_pop($sum);
//print_r($sum);
