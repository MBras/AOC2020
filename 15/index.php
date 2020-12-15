<?php

function playgame(&$input, $end)
{
    //echo "Input: ";
    //print_r($input);
    //echo "<br>";

    if (sizeof($input) % 100000 ==0) echo ".";
    if (sizeof($input) == $end) {
        $result = array_pop($input);
        $input[] = $result;
        return $result;
    }
    
    $last = array_pop($input);
    $search = array_search($last, array_reverse($input));
    //print_r( array_reverse($input));
    $input[] = $last;
    if ($search || $search === 0) {
        //echo "Looking for : " . $last . " found: " . $search . "<br>";
        $input[] = $search + 1;
    } else {
        //echo "Looking for : " . $last . " found nothing.<br>";
        $input[] = 0;
    }
    return playgame($input, $end);
}

$input = array(15,5,1,4,7,0);
echo "Part 1: " . playgame($input, 2020) . "<br>";
//print_r($input);
