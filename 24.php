<?php

$regs = [];
$results = [];
$trace = [];

function input($input)
{
    $lines = explode("\n\n", $input);

    return $lines;
}

function part1($input)
{
    global $regs;
    global $results;

    $input[0] = explode("\n", $input[0]);
    foreach ($input[0] as $line) {
        $line = explode(": ", $line);
        $regs[$line[0]] = (int)$line[1];
    }

    $input[1] = explode("\n", $input[1]);
    foreach ($input[1] as $line) {
        preg_match('/(\w+) (\w+) (\w+) -> (\w+)/', $line, $ret);
        $results[$ret[4]] = $ret;
    }

    foreach ($results as $result) {
        calc($result);
    }

    $bit = '';
    krsort($regs);
    foreach ($regs as $regname => $regval) {
        if (str_starts_with($regname, 'z')) {
            $bit .= $regval;
        }
    }

    return bindec($bit); //38869984335432
}

function part2($input)
{
}

function calc($result)
{
    global $regs;
    global $results;

    $val1 = $regs[$result[1]] ?? calc($results[$result[1]]);
    $val2 = $regs[$result[3]] ?? calc($results[$result[3]]);
//
//
//    if (str_starts_with($result[4], 'z')) {
//        $trace[$result[4]][] = [$result[1], $result[3]];
//    }

    if ($result[2] === 'OR') {
        $regs[$result[4]] = $val1 | $val2;
        return $val1 | $val2;
    }
    if ($result[2] === 'AND') {
        $regs[$result[4]] = $val1 & $val2;
        return $val1 & $val2;
    }
    if ($result[2] === 'XOR') {
        $regs[$result[4]] = $val1 ^ $val2;
        return $val1 ^ $val2;
    }

    die('error');
}

include __DIR__ . '/template.php';
