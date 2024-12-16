<?php

function input($input)
{
    $lines = explode("\n\n", $input);

    return $lines;
}

function part1($input)
{
    $sum = 0;
    foreach ($input as $opt) {
        preg_match('/Button A: X\+(\d+), Y\+(\d+)/', $opt, $A);
        preg_match('/Button B: X\+(\d+), Y\+(\d+)/', $opt, $B);
        preg_match('/Prize: X=(\d+), Y=(\d+)/', $opt, $P);

        $min = 1000000;
        for ($a = 0; $a < 100; $a++) {
            for ($b = 0; $b < 100; $b++) {
                if ($P[1] == $A[1] * $a + $B[1] * $b
                    && $P[2] == $A[2] * $a + $B[2] * $b) {
                    $min = min($min, 3 * $a + $b);
                }
            }
        }

        if ($min < 1000000) {
            $sum += $min;
        }
    }

    return $sum;
}

function part2($input)
{
    $sum = 0;
    foreach ($input as $opt) {
        preg_match('/Button A: X\+(\d+), Y\+(\d+)/', $opt, $A);
        preg_match('/Button B: X\+(\d+), Y\+(\d+)/', $opt, $B);
        preg_match('/Prize: X=(\d+), Y=(\d+)/', $opt, $P);

        $P[1] += 10000000000000;
        $P[2] += 10000000000000;

        //https://pl.m.wikipedia.org/wiki/Wzory_Cramera
        $a1 = $A[1];
        $b1 = $B[1];

        $a2 = $A[2];
        $b2 = $B[2];

        $c1 = $P[1];
        $c2 = $P[2];

        $x = ($c1 * $b2 - $b1 * $c2) / ($a1 * $b2 - $b1 * $a2);
        $y = ($a1 * $c2 - $c1 * $a2) / ($a1 * $b2 - $b1 * $a2);

        if (is_int($x) && is_int($y)) {
            $sum += 3*$x+$y;
        }
    }

    return $sum;
}

include __DIR__ . '/template.php';
