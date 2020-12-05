<?php

$lines =  file("input");

function checkpw($min, $max, $char, $password) {
    return (($password[$min - 1] == $char && $password[$max - 1] <> $char) || ($password[$min - 1] <> $char && $password[$max - 1] == $char));
}

$counter = 0;
foreach ($lines as $line) {
    // parse line
    preg_match_all("/(\d*)-(\d*) ([a-z]): (.[a-z]*)/", $line, $matches);

    // check password validita
    if (checkpw($matches[1][0], $matches[2][0], $matches[3][0], $matches[4][0])) {
        $counter++;
        print_r($matches[0][0]);
        echo "</br>";
    }
}
echo $counter;
