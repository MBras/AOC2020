<?php

$lines =  file("input");

$rows = sizeof($lines);
$cols = strlen($lines[0]) - 1;

$grid = array();

for ($x = 0; $x < $rows; $x++) {
    $grid[$x] = str_split($lines[$x]);
    echo $lines[$x] . "<br>";
}

$x = 0;
$y = 0;

$treecounter = 0;
$done = false;

while (!$done) {
    // debug info
    echo "At (".$x.",".$y.") we found: ".$grid[$y][$x % $cols]."</br>";

    // check for a tree
    if ($grid[$y][$x % $cols] == "#") $treecounter++;

    // step right 3, down 1, mod $cols
    $x = $x + 3;
    $y = $y + 1;


    // check done
    $done = ($y == $rows);
}

echo $treecounter;
