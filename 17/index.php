<?php

$lines = file("input.1");
//$lines = file("input.2");

function printgrid($g) {
    for ($z = min(array_keys($g[0][0])); $z <= max(array_keys($g[0][0])); $z++) {
        echo "z=" . $z . "<br>";
        for ($x = min(array_keys($g)); $x <= max(array_keys($g)); $x++) { 
            for ($y = min(array_keys($g[0])); $y <= max(array_keys($g[0])); $y++) {
                echo $g[$x][$y][$z];
            }
            echo "<br>";
        }
        echo "<br>";
    }
}

// calculate neighbours
function cn($g, $x, $y, $z) {
    $n = 0;
    for ($xn = $x - 1; $xn <= $x + 1; $xn++) {
        for ($yn = $y - 1; $yn <= $y + 1; $yn++) {
            for ($zn = $z - 1; $zn <= $z + 1; $zn++) {
                if (($xn <> $x || $yn <> $y || $zn <> $z) && $g[$xn][$yn][$zn] == "#") { // same mistake first as the first time, only one directiomn has to differ
                    $n++;
                }
            }
        }
    }
    if ($g[$x][$y][$z] == "#") {
        if ($n == 2 || $n == 3) {
            return "#";
        } else {
            return ".";
        }
    }
    if ($n == 3) {
        return "#";
    }
    return ".";
}

// 3D game of life
function gol($g) {
    $tg = array(); // tempgrid
    for ($x = min(array_keys($g)) - 1; $x <= max(array_keys($g)) + 1; $x++) {
        for ($y = min(array_keys($g[0])) - 1; $y <= max(array_keys($g[0])) + 1; $y++) {
            for ($z = min(array_keys($g[0][0])) - 1; $z <= max(array_keys($g[0][0])) + 1; $z++) {
                $tg[$x][$y][$z] = cn($g, $x, $y, $z);
            }
        }
    }
    return $tg;
}

function ca($g) { // count active
    $c = 0;
    for ($z = min(array_keys($g[0][0])); $z <= max(array_keys($g[0][0])); $z++) {
        for ($x = min(array_keys($g)); $x <= max(array_keys($g)); $x++) {
            for ($y = min(array_keys($g[0])); $y <= max(array_keys($g[0])); $y++) {
                if ($g[$x][$y][$z] == "#") {
                    $c++;
                }
            }
        }
    }
    return $c;
}

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$grid = array();
for ($x = 0; $x < sizeof($lines); $x++) {
    $line = str_split($lines[$x]);
    for ($y = 0; $y < sizeof($line); $y++) {
        $grid[$x][$y][0] = $line[$y];
        $maxy = $y;
    }
    $maxx = $x;
}

//echo "Before any cycles:<br><br>";
//printgrid($grid);

$cycles = 6;
for ($i = 0; $i < $cycles; $i++) {
//    echo "<br>After " . ($i + 1) . " cycles:<br><br>";
    $grid = gol($grid);
//    printgrid($grid);
}

echo "Part 1: " . ca($grid) . "<br>";


