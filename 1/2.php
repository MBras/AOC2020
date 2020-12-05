<?php

$lines =  file("input");

for ($x = 0; $x < sizeof($lines) - 2; $x++) {
    for ($y = 1; $y < sizeof($lines) - 1; $y++) {
        for ($z = 2; $z < sizeof($lines); $z++) {
            if ($lines[$x] + $lines[$y] + $lines[$z] == 2020) {
                echo $lines[$x] . " x " . $lines[$y] . " x " . $lines[$z] . " = " . $lines[$x]*$lines[$y]*$lines[$z] . "<br/>";
                break;
            }
        }
    }
}
