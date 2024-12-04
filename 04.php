<?php

function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => str_split($l), $lines);

    return $lines;
}

function part1($input)
{
    $count = 0;

    foreach ($input as $row => $line) {
        foreach ($line as $col => $char) {
            $l2r = $input[$row][$col]
                . ($input[$row][$col - 1] ?? ' ')
                . ($input[$row][$col - 2] ?? ' ')
                . ($input[$row][$col - 3] ?? ' ');
            $r2l = strrev($l2r);

            $d2t = $input[$row][$col]
                . ($input[$row - 1][$col] ?? ' ')
                . ($input[$row - 2][$col] ?? ' ')
                . ($input[$row - 3][$col] ?? ' ');
            $t2d = strrev($d2t);

            $clt = $input[$row][$col]
                . ($input[$row - 1][$col - 1] ?? ' ')
                . ($input[$row - 2][$col - 2] ?? ' ')
                . ($input[$row - 3][$col - 3] ?? ' ');
            $cld = strrev($clt);

            $crt = $input[$row][$col]
                . ($input[$row - 1][$col + 1] ?? ' ')
                . ($input[$row - 2][$col + 2] ?? ' ')
                . ($input[$row - 3][$col + 3] ?? ' ');
            $crd = strrev($crt);

            $opts = [
                'r2l' => $r2l,
                'l2r' => $l2r,
                't2d' => $t2d,
                'd2t' => $d2t,
                'clt' => $clt,
                'cld' => $cld,
                'crt' => $crt,
                'crd' => $crd
            ];

            foreach ($opts as $k => $opt) {
                if ($opt === 'XMAS') {
                    $count++;
                }
            }
        }
    }

    return $count; //2370
}

function part2($input)
{
    $count = 0;

    for ($row = 0; $row <= count($input); $row++) {
        for ($col = 0; $col <= count($input[0]); $col++) {

            $left = ($input[$row - 1][$col - 1] ?? ' ')
                . ($input[$row][$col] ?? ' ')
                . ($input[$row + 1][$col + 1] ?? ' ');

            $right = ($input[$row - 1][$col + 1] ?? ' ')
                . ($input[$row][$col] ?? ' ')
                . ($input[$row + 1][$col - 1] ?? ' ');

            $rl = strrev($left);
            $rr = strrev($right);

            if (
                ($left === 'MAS' && $right === 'MAS')
                || ($left === 'MAS' && $rr === 'MAS')
                || ($rl === 'MAS' && $right === 'MAS')
                || ($rl === 'MAS' && $rr === 'MAS')
            ) {
                $count++;
            }
        }
    }
    return $count; //1908
}

include __DIR__ . '/template.php';
