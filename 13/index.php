<?php

$lines = file("input.1");
$lines = file("input.2");

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
