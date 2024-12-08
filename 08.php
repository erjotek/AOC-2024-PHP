<?php

function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => str_split($l), $lines);

    return $lines;
}

function part1($input)
{
    return calcAntiNodes($input, false); //376
}

function part2($input)
{
    return calcAntiNodes($input, true); //1352
}

function calcAntiNodes($input, $part2 = false): int|float
{
    $ants = [];

    foreach ($input as $row => $line) {
        foreach ($line as $col => $char) {
            if ($char !== '.') {
                $ants[$char][] = [$row, $col];
            }
        }
    }

    $anty = [];

    foreach ($ants as $ant => $positions) {
        for ($i = 0; $i < count($positions) - 1; $i++) {
            for ($j = $i + 1; $j < count($positions); $j++) {
                $absRow = ($positions[$i][0] - $positions[$j][0]);
                $absCol = ($positions[$i][1] - $positions[$j][1]);

                for ($c = 1; $c < 100; $c++) {
                    $abs = [
                        [$positions[$i][0] + $c * $absRow, $positions[$i][1] + $c * $absCol],
                        [$positions[$i][0] - $c * $absRow, $positions[$i][1] - $c * $absCol],
                        [$positions[$j][0] + $c * $absRow, $positions[$j][1] + $c * $absCol],
                        [$positions[$j][0] - $c * $absRow, $positions[$j][1] - $c * $absCol],
                    ];

                    $valid = false;

                    foreach ($abs as $ab) {
                        if (isset($input[$ab[0]][$ab[1]]) &&
                            ((
                                (!$part2 && $ab[0] != $positions[$i][0] && $ab[1] !== $positions[$i][1])
                                && (!$part2 && $ab[0] != $positions[$j][0] && $ab[1] !== $positions[$j][1])
                            ) || ($part2))
                        ) {
                            $valid = true;
                            $anty[$ab[0]][$ab[1]] = $ant;
                        }
                    }

                    if (!$valid || !$part2) {
                        break;
                    }
                }
            }
        }
    }

    return array_sum(array_map('count', $anty));
}

include __DIR__ . '/template.php';
