<?php

$lines =  file("input");

print_r($lines);
for ($x = 0; $x < sizeof($lines) - 1; $x++) {
    for ($y = 1; $y < sizeof($lines); $y++) {
        if ($lines[$x] + $lines[$y] == 2020) {
            echo $x .",".$y."<br/>";
            echo $lines[$x] . " x " . $lines[$y] . " = " . $lines[$x]*$lines[$y] . "<br/>";
        }
    }
}
