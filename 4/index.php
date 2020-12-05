<?php

$lines =  file("input");

function check($data) {
    $eyecolor = array("amb", "blu", "brn", "gry", "grn", "hzl", "oth");

    if (array_key_exists('byr', $data) && 
        intval($data['byr']) >= 1920 &&
        intval($data['byr']) <= 2002) {
        $byr = true;
    } else {
        $byr = false;
    }
        
    if (array_key_exists('iyr', $data) &&
        intval($data['iyr']) >= 2010 &&
        intval($data['iyr']) <= 2020) {
        $iyr = true;
    } else {
        $iyr = false;
    }
    
    if (array_key_exists('eyr', $data) &&
        intval($data['eyr']) >= 2020 &&
        intval($data['eyr']) <= 2030) {
        $eyr = true;
    } else {
        $eyr = false;
    }
    
    if (array_key_exists('hgt', $data)) {
        // check height
        if (!preg_match("/(\d*)(cm|in)/", $data['hgt'], $match)) $hgt = false;
        else {
            if ($match[2] == "cm") {
                if (intval($match[1]) >= 150 &&
                    intval($match[1]) <= 193)
                    $hgt = true;
                else $hgt = false;
            } else {
                if (intval($match[1]) >= 59 &&
                    intval($match[1]) <= 76)
                    $hgt = true;
                else $hgt = false;
            }
        }
    } else {
        $hgt = false;
    }

    if (array_key_exists('hcl', $data)) {
        $hcl = (preg_match("/#[0-9a-f]{6}/", $data['hcl']));
    } else {
        $hcl = false;
    }

    if (array_key_exists('ecl', $data)) {
        $ecl = (in_array($data['ecl'], $eyecolor)); 
    } else {
        $ecl = false;
    }

    if (array_key_exists('pid', $data)) {
        $pid = (preg_match("/[0-9]{9}/", $data['pid']) && strlen($data['pid']) == 9);
    } else {
        $pid = false;
    }

    return $byr && $iyr && $eyr && $hgt && $hcl && $ecl && $pid;
}

$valid = 0;
$passportdata = array();

foreach($lines as $line) {
    $line = str_replace(array("\n", "\r"), '', $line);
    // check for empty line to verify passport and start the new passprt analysis
    if ($line == "") {
        //print_r($passportdata);
        echo "Next passport!</br>";
        if (check($passportdata)) $valid++;
        $passportdata = array();
    } else {
        // otherwise parse the line into passportdata
        $matches = explode(" ", $line);
        foreach($matches as $match) {
            list($key, $value) = explode(":", $match);
            $passportdata[$key] = $value;
        }
    }
    //print_r($passportdata);
}
// check final set of data
if (check($passportdata)) $valid++;

echo $valid;

