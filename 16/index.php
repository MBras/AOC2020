<?php

$lines = file("input.1");
$lines = file("input.2");

$x = 0;

// process rules
while (trim($lines[$x]) != "") {
    preg_match_all("/([a-z ]*?): (\d*)-(\d*) or (\d*)-(\d*)/", $lines[$x], $match);
    $key = $match[1][0];
    $rules[$match[1][0]]["min1"] = $match[2][0] ;
    $rules[$match[1][0]]["max1"] = $match[3][0] ;
    $rules[$match[1][0]]["min2"] = $match[4][0] ;
    $rules[$match[1][0]]["max2"] = $match[5][0] ;
    $x++;
}
//echo "Rules: ";
//print_r($rules);

// process your ticket
$x += 2;
$yourticket = explode(",", trim($lines[$x]));
//echo "<br>Your ticket: ";
//print_r($yourticket);

// process nearby tickets 
$x += 3;
while ($x < sizeof($lines)) {
    $nearbytickets[] = explode(",", trim($lines[$x]));
    $x++;
}
//echo "<br>Nearby tickets: ";
//print_r($nearbytickets);

echo "<br>=================================================================<br>";
echo "Start processing every ticket<br>";

// check each nearby ticket
$error = 0;
$invalid = array();
foreach ($nearbytickets as $key => $ticket) {
    // check each value
    foreach ($ticket as $pos => $value) {
        //echo $value;
        $valid = array();
        // check value against every rule
        foreach ($rules as $rulename => $rule) {
            $valid[] = (($value >= $rule["min1"] && $value <= $rule["max1"]) || ($value >= $rule["min2"] && $value <= $rule["max2"]));
        }
        //echo " - " . array_sum($valid) . "<br>";
        if (!array_sum($valid)) {
            $error += $value;
            //echo "Ticket " . $key . " is invalid.<br>";
            $invalid[] = $key;
            break;
        }
    }
}
echo "<br>Part 1: " . $error . "<br>";
echo "<br>=================================================================<br>";

// cleanup nearby tickets using the invalid array
foreach($invalid as $key) {
    unset($nearbytickets[$key]);
}

error_reporting(E_ERROR | E_WARNING | E_PARSE);
$validrule = array();
foreach ($nearbytickets as $key => $ticket) {
    // check each value
    foreach ($ticket as $pos => $value) {
        $valid = array();
        // check value against every rule
        foreach ($rules as $rulename => $rule) {
            $validrule[$rulename][$pos] += (($value >= $rule["min1"] && $value <= $rule["max1"]) || ($value >= $rule["min2"] && $value <= $rule["max2"]));
        }
    }
}

// now determine for every column which rule always applies
echo "Number of valid tickets: " . sizeof($nearbytickets) . "<br>";

// determine which rule matches exactly the number of tickets once
$done = false;
$columns = array();

while (!$done) {
    foreach($validrule as $key => $rule) {
        // check how many keys appear as many times as there are tickets
        if (sizeof(array_keys($rule, sizeof($nearbytickets))) == 1) {
            // if that appearance is 1 than we found our column for given key
            echo $key . " appears once for position " . array_search(sizeof($nearbytickets), $rule) . ".<br>";
            $columns[$key] = array_search(sizeof($nearbytickets), $rule);

            // remove that column from all tickets and do this again until all columns are assigned and thus gone
            //print_r($validrule);
            foreach($validrule as &$cleanuprule) {
                unset($cleanuprule[$columns[$key]]);
            }
            unset($validrule[$key]);
            //print_r($validrule);
            
            break;
        }
    }
    // check if we are done
    if (sizeof($validrule) == 0) $done = true;
}

$score = 1;
print_r($yourticket);
foreach($columns as $key => $value) {
    if (substr($key, 0, 9) == "departure") {
        echo "Looking for field " . $value . " on your ticket.<br>";
        $score *= $yourticket[$value];
    }
}

echo "Part 2: " . $score;
