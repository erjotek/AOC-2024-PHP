<?php

function input($input)
{
    $i3nput = <<<TEST
Button A: X+94, Y+34
Button B: X+22, Y+67
Prize: X=8400, Y=5400

Button A: X+26, Y+66
Button B: X+67, Y+21
Prize: X=12748, Y=12176

Button A: X+17, Y+86
Button B: X+84, Y+37
Prize: X=7870, Y=6450

Button A: X+69, Y+23
Button B: X+27, Y+71
Prize: X=18641, Y=10279
TEST;

    $lines = explode("\n\n", $input);
//    $lines = array_map(fn($l) => explode("\n",$l), $lines);

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
