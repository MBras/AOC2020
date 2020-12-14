<?php

$lines = file("input.1");
$lines = file("input.2");
//$lines[1] = "1789,37,47,1889"; //1202161486

$start = intval($lines[0]);
$busses = array_filter(explode(",", $lines[1]), function ($element) { return ($element != "x");}); 

$mindeparture = $start + max($busses);
$minbus = 0;
foreach ($busses as $bus) {
    $departure = $start + ($bus - $start % $bus);
    echo "Bus: " . $bus . " earliest depart after " . $start . ": " . $departure . "<br>";
    if ($departure < $mindeparture) {
        $mindeparture = $departure;
        $minbus = $bus;
    }
}
echo "Part 1: " . (($mindeparture - $start) * $minbus) ."<br>";

//==============[ Part II ]=======================

print_r($busses);
echo "<br>";

$stepsize = 1;
$timestamp = 1;
foreach ($busses as $buskey => $busval) {
    if ($busval != "x") {
        echo $buskey . " - " . $busval . "<br>";
        while (1) {
            if (($timestamp + $buskey) % $busval == 0) {
                $stepsize *= $busval;
                echo "Timestamp: " . $timestamp . ", step: " . $stepsize . "<br>";
                break;
            }
            $timestamp += $stepsize;
        }
    }
}
