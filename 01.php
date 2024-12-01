<?php

function input($input)
{

    $input = explode("\n", $input);
    $input = array_map(fn($l) => explode('   ', $l), $input);
    $first = array_column($input, '0');
    sort($first);
    $second = array_column($input, '1');
    sort($second);


    return compact('first', 'second');
}

function part1($input)
{
    $sum = 0;

    foreach ($input['first'] as $k => $f) {
        $sum += abs($f - $input['second'][$k]);
    }

    return $sum; //1222801

}

function part2($input)
{
    $second = array_count_values($input['second']);

    $sum = 0;

    foreach ($input['first'] as $f) {
        $sum += $f * ($second[$f] ?? 0);
    }

    return $sum; //22545250
}

include __DIR__ . '/template.php';
