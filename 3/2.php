<?php

$lines =  file("input");

$rows = sizeof($lines);
$cols = strlen($lines[0]) - 1;

$grid = array();

for ($x = 0; $x < $rows; $x++) {
    $grid[$x] = str_split($lines[$x]);
    //echo $lines[$x] . "<br>";
}

function checkslope($xstep, $ystep) {
    global $cols, $grid, $rows;
    
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
        $x = $x + $xstep;
        $y = $y + $ystep;

        // check done
        $done = ($y >= $rows);
    }

    return $treecounter;
}

echo checkslope(1,1) * checkslope(3,1) * checkslope(5,1) * checkslope(7,1) * checkslope(1,2);
