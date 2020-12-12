<?php

$lines = file("input.2");
//$lines = file("input.1");

$dirs = array("N", "E", "S", "W");
$movedir = array("N" => 0, "E" => 1, "S" => 2, "W" => 3); 

$xpos = 0;
$ypos = 0;
$xwp = 10;
$ywp = -1;

function move(&$x, &$y, $dist, $dir) {
    switch ($dir) {
        case 0:
            $y -= $dist;
            break;
        case 1:
            $x += $dist;
            break;
        case 2:
            $y += $dist;
            break;
        case 3:
            $x -= $dist;
            break;
    }
}

function rotate(&$x, &$y, $dir) {
    $tempx = $x;
    switch ($dir) {
        case 90:
        case -270: 
            $x = -$y;
            $y = $tempx;
            break;
        case 180:
        case -180:
            $x = -$x;
            $y = -$y; 
            break;
        case 270:
        case -90:
            $x = $y;
            $y = -$tempx;
            break;
    }
}

foreach ($lines as $line) {
    preg_match_all("/([R|L]|N|E|S|W|F)(\d*)/", $line, $matches);

    $distance = $matches[2][0];
    $direction = $matches[1][0];

    switch ($direction) {
        case "L":
            rotate($xwp, $ywp, -$distance);
            echo "Rotating waypoint " . $distance . " degrees left to (" . $xwp . ", " . $ywp . ").<br>";
            break;
        case "R":
            rotate($xwp, $ywp, $distance);
            echo "Rotating waypoint " . $distance . " degrees right to (" . $xwp . ", " . $ywp . ").<br>";
            break;
        case "F":
            $xpos += $xwp * $distance;
            $ypos += $ywp * $distance;
            echo "Moving towards waypoint " . ($xwp * $distance) . " E, " . ($ywp * $distance) . " S to (" . $xpos . "," . $ypos . ").<br>";
            break;
        case "N":
        case "E":
        case "S":
        case "W":
            move($xwp, $ywp, $distance, $movedir[$direction]);
            echo "Moving waypoint " . $dirs[$movedir[$direction]] . " " . $distance . " spots to (" . $xwp . "," . $ywp . ").<br>";
            break;
    }
}

echo "Part 2: " . (abs($xpos) + abs($ypos)) . "<br>";
