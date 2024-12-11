<?php

function input($input)
{
    $lines = explode(" ", $input);
    $lines = array_map('intval', $lines);

    return $lines;
}

function part1($input)
{
    return calcStones($input, 25); //203953
}

function part2($input)
{
    return calcStones($input, 75); //242090118578155
}

function calcStones($input, $rounds)
{

    $reps = [];
    foreach ($input as $stone) {
        $reps[$stone] ??= 0;
        $reps[$stone]++;
    }

    for ($i = 0; $i<$rounds; $i++) {
        $ni = [];

        foreach ($reps as $stone => $count) {
            if ($stone == 0) {
                $ni[1] ??= 0;
                $ni[1] += $count;
            } elseif (strlen($stone) % 2 == 0) {
                $l = (int)substr($stone, 0, strlen($stone) / 2);
                $r = (int)substr($stone, strlen($stone) / 2);
                $ni[$l] ??= 0;
                $ni[$r] ??= 0;

                $ni[$l] += $count;
                $ni[$r] += $count;
            } else {
                $ni[$stone * 2024] ??= 0;
                $ni[$stone * 2024] = $count;
            }
        }

        $reps = $ni;
    }

    return array_sum($reps);
}

include __DIR__ . '/template.php';
