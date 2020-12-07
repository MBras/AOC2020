<?php

$lines =  file("input");

$search = "shiny gold";
$bags = array();

function r_search($needle) {
    global $lines, $bags;

    foreach ($lines as $line) {
        if (strpos($line, $needle, 1)) {
            //echo $needle . " found in: " . $line . "<br>";
            preg_match_all("/^(\S* \S*)/", $line, $matches);
            //echo "Look for: " .$matches[0][0] . "<br>";
            r_search($matches[0][0]);
            $bags[] = $matches[0][0]; 
        }
    }
}

r_search($search);
//print_r(array_unique($bags));
echo "Part 1 :". sizeof(array_unique($bags)) ."<br>";

//----- part 2
function count_bags($needle) {
    global $lines;

    foreach ($lines as $line) {
        if (strpos($line, $needle) === 0) {
            // parse line into contained bags
            $sum = 1;
            preg_match_all("/(\d) (\S* \S*)/", $line, $matches);
            //print_r($matches);

            for ($x = 0; $x < sizeof($matches[0]); $x++) {
                $sum += ($matches[1][$x] * count_bags($matches[2][$x]));
            }
            return $sum;
        }
    }
}

echo "Part 2 :". (count_bags($search) - 1) ."<br>"; 
