<?php

function input($input)
{
    $input = explode("\n\n", $input);

    $input[0] = explode("\n", $input[0]);
    $input[1] = str_split(str_replace("\n", '', $input[1]));
    return $input;
}

function part1($input)
{
    $map = array_map('str_split', $input[0]);

    return robots($map, $input[1]); //1429911
}

function part2($input)
{
    $map = array_map(fn($l) => str_replace(['#', '.', 'O', '@'], ['##', '..', '[]', '@.'], $l), $input[0]);
    $map = array_map('str_split', $map);

    return robots($map, $input[1]); //1453087
}


function robots($map, $ops)
{
    $pos = [];
    foreach ($map as $row => $cols) {
        foreach ($cols as $col => $char) {
            if ($char === '@') {
                $pos = [$row, $col];
                break;
            }
        }
    }

    foreach ($ops as $op) {
        [$map, $pos] = move($map, $op, $pos);
    }

    $sum = 0;
    foreach ($map as $row => $cols) {
        foreach ($cols as $col => $char) {
            if ($char === 'O' || $char === '[') {
                $sum += 100 * $row + $col;
            }
        }
    }

    return $sum; // 1453087
}

function move($map, $opname, $pos)
{
    $dirs = ['>' => [0, 1], '<' => [0, -1], '^' => [-1, 0], 'v' => [1, 0]];
    $op = $dirs[$opname];
    $newPos = [$pos[0] + $op[0], $pos[1] + $op[1]];

    $newMap = $map;

    if ($opname === '<' || $opname === '>') {
        $check = checkMove($newMap, $pos, $op);
    }

    if ($opname === '^' || $opname === 'v') {
        $check = checkMove($newMap, $pos, $op, true);
    }

    return $check ? [$newMap, $newPos] : [$map, $pos];
}

function checkMove(&$map, $pos, $op, $vertical = false)
{
    $newPos = [$pos[0] + $op[0], $pos[1] + $op[1]];

    if ($map[$newPos[0]][$newPos[1]] === '#') {
        return false;
    }

    if ($map[$newPos[0]][$newPos[1]] === '.') {
        $check = true;
    }

    if ($map[$newPos[0]][$newPos[1]] === 'O') {
        $check = checkMove($map, $newPos, $op, $vertical);
    }

    if ($map[$newPos[0]][$newPos[1]] === '[') {
        $check = checkMove($map, $newPos, $op, $vertical);
        if ($vertical) {
            $check = $check && checkMove($map, [$newPos[0], $newPos[1] + 1], $op, $vertical);
        }
    }

    if ($map[$newPos[0]][$newPos[1]] === ']') {
        $check = checkMove($map, $newPos, $op, $vertical);
        if ($vertical) {
            $check = $check && checkMove($map, [$newPos[0], $newPos[1] - 1], $op, $vertical);
        }
    }

    if ($check) {
        $map[$newPos[0]][$newPos[1]] = $map[$pos[0]][$pos[1]];
        $map[$pos[0]][$pos[1]] = '.';
    }

    return $check;
}

include __DIR__ . '/template.php';
