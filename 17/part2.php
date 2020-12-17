<?php

$lines = file("input.1");
$lines = file("input.2");

function printgrid($g) {
    for ($z = min(array_keys($g[0][0])); $z <= max(array_keys($g[0][0])); $z++) {
        for ($w = min(array_keys($g[0][0][0])); $w <= max(array_keys($g[0][0][0])); $w++) {
            echo "z=" . $z . ", w=" . $w . "<br>";
            for ($x = min(array_keys($g)); $x <= max(array_keys($g)); $x++) { 
                for ($y = min(array_keys($g[0])); $y <= max(array_keys($g[0])); $y++) {
                    echo $g[$x][$y][$z][$w];
                }
                echo "<br>";
            }
            echo "<br>";
        }
    }
}

// calculate neighbours
function cn($g, $x, $y, $z, $w) {
    $n = 0;
    for ($xn = $x - 1; $xn <= $x + 1; $xn++) {
        for ($yn = $y - 1; $yn <= $y + 1; $yn++) {
            for ($zn = $z - 1; $zn <= $z + 1; $zn++) {
                for ($wn = $w - 1; $wn <= $w + 1; $wn++) {
                    if (($xn <> $x || $yn <> $y || $zn <> $z || $wn <> $w) && $g[$xn][$yn][$zn][$wn] == "#") { // same mistake first as the first time, only one directiomn has to differ
                        $n++;
                    }
                }
            }
        }
    }
    //echo "(".$x.",".$y.",".$z.",".$w.") has ".$n." neighbours<br>";
    if ($g[$x][$y][$z][$w] == "#") {
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
                for ($w = min(array_keys($g[0][0][0])) - 1; $w <= max(array_keys($g[0][0][0])) + 1; $w++) {
                    $tg[$x][$y][$z][$w] = cn($g, $x, $y, $z, $w);
                }
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
                for ($w = min(array_keys($g[0][0][0])); $w <= max(array_keys($g[0][0][0])); $w++) {
                    if ($g[$x][$y][$z][$w] == "#") {
                        $c++;
                    }
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
        $grid[$x][$y][0][0] = $line[$y];
        $maxy = $y;
    }
    $maxx = $x;
}

echo "Before any cycles:<br><br>";
//printgrid($grid);

$cycles = 6;
for ($i = 0; $i < $cycles; $i++) {
    //echo "<br>After " . ($i + 1) . " cycles:<br><br>";
    $grid = gol($grid);
    //printgrid($grid);
}

echo "Part 2: " . ca($grid) . "<br>";


