<?php


$lines = file("input.2");

$dir = 1; // start out facing E
$dirs = array("N", "E", "S", "W");
$movedir = array("N" => 0, "E" => 1, "S" => 2, "W" => 3); 

$xpos = 0;
$ypos = 0;

$visited[0][0] = "x";

function move(&$grid, &$x, &$y, $dist, $dir) {
    global $dirs;

    echo "Moving " . $dirs[$dir] . " " . $dist . " spots.<br>";
    for ($d = 0; $d < $dist; $d++) {
        switch ($dir) {
            case 0:
                $y--;
                break;
            case 1:
                $x++;
                break;
            case 2:
                $y++;
                break;
            case 3:
                $x--;
                break;
        }
        $grid[$x][$y] = "x";
    }
    echo "Moved to (" . $x . ", " . $y . ")<br>";
}

foreach ($lines as $line) {
    preg_match_all("/([R|L]|N|E|S|W|F)(\d*)/", $line, $matches);

    $changedir = $matches[2][0] / 90;
    switch ($matches[1][0]) {
        case "L":
            $dir = ($dir + 4 - $changedir) % 4;
            break;
        case "R":
            $dir = ($dir + 4 + $changedir) % 4;
            break;
        case "F":
            move($visited, $xpos, $ypos, $matches[2][0], $dir);
            break;
        case "N":
        case "E":
        case "S":
        case "W":
            move($visited, $xpos, $ypos, $matches[2][0], $movedir[$matches[1][0]]);
            break;
    }

    // debug printing info
    switch ($matches[1][0]) {
        case "L":
        case "R":
            echo "Turning " . $matches[1][0] . " " . $matches[2][0] . " degrees, new direction " . $dirs[$dir] . ".<br>";
            break;
    }
}

echo "Part 1: " . (abs($xpos) + abs($ypos)) . "<br>";

/*
90 = 1
180 = 2
270 = 3
*/

