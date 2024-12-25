<?php

function input($input)
{
    $lines = explode("\n\n", $input);
    $lines = array_map(fn($l) => explode("\n", $l), $lines);

    return $lines;
}

function part1($input)
{
    $keys = [];
    $locks = [];
    foreach ($input as $test) {
        $sig = [];
        $val = array_map('str_split', $test);
        for ($i = 0; $i < 5; $i++) {
            $sig[] = (array_count_values(array_column($val, $i))['#'] - 1);
        }

        if ($test[0] === '#####') {
            $locks[] = $sig;
        } else {
            $keys[] = $sig;
        }
    }

    $perfect = 0;
    foreach ($locks as $lock) {
        foreach ($keys as $key) {
            for ($i = 0; $i < 5; $i++) {
                if ($key[$i] + $lock[$i] > 5) {
                    continue 2;
                }
            }
            $perfect++;
        }
    }

    return $perfect;
}

function part2($input)
{
}

include __DIR__ . '/template.php';
