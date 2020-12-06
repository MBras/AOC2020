<?php

$lines =  file("input");
$sum = 0;

$data = array();
$nrpassengers = 0;
foreach($lines as $line) {
    $line = str_replace(array("\n", "\r"), '', $line);
    if ($line == "") {
        // process characters;
        $sum += sizeof(array_unique($data));
        echo sizeof(array_unique($data)) ."<br>";
        $data = array();
    } else {
        // add characters to data
        $data = array_merge($data, str_split($line));
    }
}
$sum += sizeof(array_unique($data));
echo "uitkomst 1:" .$sum ."<br>";


// part 2
$lines =  file("input");
$sum = 0;

$data = array();
$nrpassengers = 0;
foreach($lines as $line) {
    $line = str_replace(array("\n", "\r"), '', $line);
    if ($line == "") {
        // process characters;
        //echo $nrpassengers ."<br>";
        //print_r($data);
        foreach($data as $char) {
            if ($char == $nrpassengers) $sum++;
        }

        $data = array();
        $nrpassengers = 0;
    } else {
        // add characters to data
        foreach(str_split($line) as $char) {
            if (isset($data[$char])) {
                $data[$char]++;
            } else {
                $data[$char] = 1;
            }
        }
        $nrpassengers++;
    }
}
//print_r($data);
foreach($data as $char) {
    if ($char == $nrpassengers) $sum++;
}
echo "uitkomst 2:" .$sum;
