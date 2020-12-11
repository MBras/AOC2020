<?php

$lines =  file("input.2");

$grid = array();
foreach($lines as $line) {
    $grid[] = str_split($line);
}

function cs($g, $x, $y) // checkseat
{
    //echo "Called for " . $x.",".$y."<br>";
    if ($g[$x][$y] == ".") {
        return ".";
    }
    $occupied = 0;
    for ($a = max($x - 1, 0); $a <= min($x + 1, sizeof($g) - 1); $a++) {
        for ($b = max($y - 1, 0); $b <= min($y + 1, sizeof($g[0]) - 1); $b++) {
            //echo "Checking (" . $a .",".$b."): " . $g[$a][$b] ."<br>";

            if (($a <> $x) || ($b <> $y)) { // don't check the seat itself
                //echo "Checking (" . $a .",".$b."): " . $g[$a][$b] ."<br>";
                if ($g[$a][$b] == "#") {
                    $occupied++;
                }
            }
        }
    }
    if ($g[$x][$y] == "L" && $occupied == 0) {
        return "#";
    }
    if ($g[$x][$y] == "#" && $occupied >= 4) {
        return "L";
    }
    return $g[$x][$y];
}


function scan($g, $x, $y, $xstep, $ystep)
{
    while (1) {
        $x += $xstep;
        $y += $ystep;

        if ($x < 0 || $y < 0 || $x == sizeof($g) || $y == sizeof($g[0])) {
            return 0;
        }
        if ($g[$x][$y] == "#") {
            return 1;
        }
        if ($g[$x][$y] == "L") {
            return 0;
        }
    }
}

function cs2($g, $x, $y) // checkseat
{
    if ($g[$x][$y] == ".") {
        return ".";
    }
    $occupied = 0;
    
    // just have 8 identical loops to check all directions until the edge or an occupied seat is reached
    $occupied += scan($g, $x, $y, 0, 1); 
    $occupied += scan($g, $x, $y, 1, 1);
    $occupied += scan($g, $x, $y, 1, 0);
    $occupied += scan($g, $x, $y, -1, 0);
    $occupied += scan($g, $x, $y, -1, 1);
    $occupied += scan($g, $x, $y, -1, -1);
    $occupied += scan($g, $x, $y, 0, -1);
    $occupied += scan($g, $x, $y, 1, -1);

    if ($g[$x][$y] == "L" && $occupied == 0) {
        return "#";
    }
    if ($g[$x][$y] == "#" && $occupied >= 5) {
        return "L";
    }
    return $g[$x][$y];

    return $occupied;
}


function counts($g) 
{
    $s = 0;
    for ($x = 0; $x < sizeof($g); $x++) {
        for ($y = 0; $y < sizeof($g[0]); $y++) {
            if ($g[$x][$y] == "#") $s++;
        }
    }
    return $s;
}

function ps($g) 
{
    for ($x = 0; $x < sizeof($g); $x++) {
        for ($y = 0; $y < sizeof($g[0]); $y++) {
            echo $g[$x][$y];
        }
        echo "<br>";
    }
    echo "<br>";
}

$os = 0; // occupied seats
//ps($grid);

while (1) {
    $tempgrid = $grid;
    
    for ($x = 0; $x < sizeof($grid); $x++) {
        for ($y = 0; $y < sizeof($grid[0]); $y++) {
            $tempgrid[$x][$y] = cs($grid, $x, $y);
            //echo "<br>";
        }
    }
    //ps($tempgrid);
    $grid = $tempgrid;

    if ($os == counts($grid)) {
        echo "Part 1 done: " . $os . "<br>";
        break;
    }
    $os = counts($grid);
}

$grid = array();
foreach($lines as $line) {
    $grid[] = str_split($line);
}
$os = 0;

while (1) {
    $tempgrid = $grid;

    for ($x = 0; $x < sizeof($grid); $x++) {
        for ($y = 0; $y < sizeof($grid[0]); $y++) {
            $tempgrid[$x][$y] = cs2($grid, $x, $y);
        }
    }
    //ps($tempgrid);
    $grid = $tempgrid;

    if ($os == counts($grid)) {
        echo "Part 2 done: " . $os . "<br>";
        break;
    }
    $os = counts($grid);
}
