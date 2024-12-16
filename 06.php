<?php

$visitied = [];
function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => str_split($l), $lines);

    return $lines;
}

function part1($input)
{
    return check($input); //5461
}

function part2($input)
{
    global $visitied;

    $count = 0;

    foreach ($visitied as $row => $cols) {
        foreach ($cols as $col => $true) {
            $ninput = $input;
            $ninput[$row][$col] = '@';

            $wyn = checkloop($ninput);
            $count += $wyn;
        }
    }


    return $count; //1836
}



function check($input): int
{
    global $visitied;
    $dir = 0;
    $dirs = [[-1, 0], [0, 1], [1, 0], [0, -1]];


    foreach ($input as $row => $line) {
        foreach ($line as $col => $char) {
            if ($char === '^') {
                $position = [$row, $col];
                $visitied[$row][$col] = true;
                $input[$row][$col] = '.';
            }
        }
    }


    $npos = [];
    while (true) {
        $npos[0] = $position[0] + $dirs[$dir][0];
        $npos[1] = $position[1] + $dirs[$dir][1];

        if (!isset($input[$npos[0]][$npos[1]])) {
            break;
        }

        if ($input[$npos[0]][$npos[1]] !== '.') {
            $dir = ($dir + 1) % 4;
            continue;
        }

        $visitied[$npos[0]][$npos[1]] = true;
        $position[0] = $npos[0];
        $position[1] = $npos[1];
    }
    return array_sum(array_map(fn($x) => array_sum($x), $visitied));
}


function checkloop($input): bool
{
    $dir = 0;
    $dirs = [[-1, 0], [0, 1], [1, 0], [0, -1]];
    $npos = [];
    $visitied = [];

    foreach ($input as $row => $line) {
        foreach ($line as $col => $char) {
            if ($char === '^') {
                $position = [$row, $col];
                $input[$row][$col] = '.';
            }
        }
    }

    if (empty($position)) {
        return false;
    }

    while (true) {
        $npos[0] = $position[0] + $dirs[$dir][0];
        $npos[1] = $position[1] + $dirs[$dir][1];

        if (isset($visitied[$npos[0]][$npos[1]][$dir])) {
            return true;
        }

        if (!isset($input[$npos[0]][$npos[1]])) {
            return false;
        }

        if ($input[$npos[0]][$npos[1]] !== '.') {
            $dir = ($dir + 1) % 4;
            continue;
        }

        $visitied[$npos[0]][$npos[1]][$dir] = true;

        $position[0] = $npos[0];
        $position[1] = $npos[1];
    }
}

include __DIR__ . '/template.php';