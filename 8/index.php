<?php

$lines =  file("input");

$ic = 0;
$acc = 0;

$vi = array(); // visited instructions

while (!in_array($ic, $vi)) {
    $vi[] = $ic;
    preg_match_all("/(\S{3}) ([+|-]\d*)/", $lines[$ic], $matches);

    //print_r($matches);
    //echo "Instruction pointer: " . $ic . "<br>";
    //echo "Instruction: " . $matches[1][0] . "<br>";
    //echo "Parameter: " . intval($matches[2][0]) . "<br>";
    //echo "Accumulator: " . $acc . "<br>";
    //print_r($vi);
    switch ($matches[1][0]) {
        case "nop":
            $ic++;
            break;
        case "acc":
            $acc += intval($matches[2][0]);
            $ic++;
            break;
        case "jmp":
            $ic += intval($matches[2][0]);
            break;
    }
}
echo "Part 1: ". $acc;

//------- part 2

function runprog($prog) {
    $vi = array(); // visited instructions

    $ic = 0;
    $acc = 0;

    while (!in_array($ic, $vi)) {
        if ($ic == sizeof($prog)) {
            echo "Part 2: " . $acc . "<br>";
            return;
        }
        $vi[] = $ic;
        preg_match_all("/(\S{3}) ([+|-]\d*)/", $prog[$ic], $matches);
        switch ($matches[1][0]) {
            case "nop":
                $ic++;
                break;
            case "acc":
                $acc += intval($matches[2][0]);
                $ic++;
                break;
            case "jmp":
                $ic += intval($matches[2][0]);
                break;
        }
    }
}


for ($x = 0; $x < sizeof($lines); $x++) {
    $newlines = $lines;
    // check if this instruction can change, then tesrun the programm to see if it executed to the end
    preg_match_all("/(\S{3}) ([+|-]\d*)/", $lines[$x], $matches);
    switch ($matches[1][0]) {
        case "nop":
            $newlines[$x] = "jmp " . $matches[2][0];
            runprog($newlines);
            break;
        case "jmp":
            $newlines[$x] = "nop " . $matches[2][0];
            runprog($newlines);
            break;
    }
}
