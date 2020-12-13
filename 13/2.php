<?php

//$lines = file("input.1");
$lines = file("input.2");
//$lines[1] = "17,x,13,19";

$busses = explode(",", $lines[1]);

$timestamp = 100000393600000;
while (1) {
    $valid = true;
    if($timestamp % 100000 == 0) echo "Checking " . $timestamp . "<br>";
    for ($x = 0; $x < sizeof($busses); $x++) {
        // check if valid
        //echo "* Checking bus: " . $busses[$x] . "<br>"; 
        if ($busses[$x] <> "x" && (($busses[$x] - ($timestamp % $busses[$x])) % $busses[$x]) <> $x) {
            //echo $timestamp . ": bus: " . $busses[$x] . " value: " . (($busses[$x] - ($timestamp % $busses[$x])) % $busses[$x]). "<br>";
            $valid = false;
            break;
        }
    }
    if ($valid) {
        echo $timestamp . " is valid!<br>";
        break;
    }
    $timestamp++;
}
