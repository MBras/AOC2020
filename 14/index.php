<?php

$input = file_get_contents("input.1");
$input = file_get_contents("input.2");

$regexp = "/mask = ([X01]{36}(\nmem\[\d*\] = \d*)*)*/";
preg_match_all($regexp, $input, $matches);

$mem = array();

foreach($matches[0] as $match) {
    // get mask
    preg_match_all("/mask = ([X01]{36})/", $match, $output);
    $mask = $output[1][0];
    //echo $mask ."<br>";

    preg_match_all("/(mem\[(\d*)\] = (\d*))/", $match, $output);
    for($x = 0; $x < sizeof($output[0]); $x++) {
        // fill memory
        $mem[$output[2][$x]] = sprintf("%036s", decbin($output[3][$x]));

        // update memory
        //echo "Updating memory " . $output[2][$x] . " from " . $mem[$output[2][$x]];
        for ($y = 0; $y < strlen($mask); $y++) {
            if ($mask[$y] <> "X") {
                $mem[$output[2][$x]][$y] = $mask[$y];
            }
        }
        //echo " to  " . $mem[$output[2][$x]] . "<br>";
    }
}
//print_r($mem);

$sum = 0;
foreach ($mem as $m) {
    $sum += intval($m, 2);
}

echo "Part 1: " . $sum . "<br>";

//=================[ Part II ]=================

function setmem(&$memory, $post, $keypre, $keypost, $value) {
    /*
    echo "setmem called: <br>";
    print_r($memory);
    echo "<br>";
    echo "post: " . $post . "<br>";
    echo "keypre: " . $keypre . "<br>";
    echo "keypost: " . $keypost . "<br>";
    echo "value: " . $value . "<br>";
    */
    $done = false;
    while (!$done) {
        if (strlen($post) == 0) {
            // done with the mask, proceed to write the value
            $memory[intval($keypre, 2)] = $value;
            //echo "I'm done<br>";
            $done = true;
        } else {
            $mask = $post[0];
            switch ($mask) {
                case "0":
                    $keypre .= $keypost[0];
                    $post = substr($post, 1);
                    $keypost = substr($keypost, 1);
                    //echo "mask = 0<br>";
                    break;
                case "1":
                    $keypre .= "1";
                    $post = substr($post, 1);
                    $keypost = substr($keypost, 1);
                    //echo "mask = 1<br>";
                    break;
                case "X":
                    //echo "Calling setmem 0<br>";
                    setmem($memory, substr($post, 1), $keypre . "0", substr($keypost, 1), $value);
                    //echo "Calling setmem 1<br>";
                    setmem($memory, substr($post, 1), $keypre . "1", substr($keypost, 1), $value);
                    //echo "Done after 2 setmems<br>";
                    $done = true; // <=- so important!!! :D
                    break;
            }
            // not done processing the mask yet so check the next character   
        }
    }
}

preg_match_all($regexp, $input, $matches);

$mem = array();

foreach($matches[0] as $match) {
    // get mask
    preg_match_all("/mask = ([X01]{36})/", $match, $output);
    $mask = $output[1][0];
    // echo "mask: " . $mask . "<br>";

    preg_match_all("/(mem\[(\d*)\] = (\d*))/", $match, $output);
    for($x = 0; $x < sizeof($output[0]); $x++) {
        // smart thing to recursively generate all memory addresses
        setmem($mem, $mask, "", sprintf("%036s", decbin($output[2][$x])), $output[3][$x]);
    }
}

// print_r($mem);

$sum = 0;
foreach ($mem as $m) {
    $sum += $m;
}
echo "Part 2: " . $sum . "<br>";
