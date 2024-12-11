<?php

function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => str_split($l), $lines);

    return $lines;
}

function part1($input)
{
    return calcDisk($input, false); // 737
}

function part2($input)
{
    return calcDisk($input, true); //1619
}

function calcDisk($input, $part2 = false): int
{
    $zeros = [];

    foreach ($input as $row => $line) {
        foreach ($line as $col => $val) {
            if ($val == 0) {
                $zeros[] = [$row, $col];
            }
        }
    }

    $ends = [];
    foreach ($zeros as $zid => $start) {
        $visited = [];

        $q = new SplMaxHeap();
        $q->insert([$start, '']);
        while (!$q->isEmpty()) {
            [$pos, $track] = $q->extract();

            $last = $input[$pos[0]][$pos[1]];

            foreach ([[0, -1], [0, 1], [1, 0], [-1, 0]] as $delta) {
                $np[0] = $pos[0] + $delta[0];
                $np[1] = $pos[1] + $delta[1];


                if (!isset($input[$np[0]][$np[1]])) {
                    continue;
                }

                if (!$part2 && isset($visited[$np[0]][$np[1]])) {
                    continue;
                }

                if ($input[$np[0]][$np[1]] != $last[0] + 1) {
                    continue;
                }

                $visited[$pos[0]][$pos[1]] = true;

                $newtrack = ($part2 ? $track : '') . ' - ' . implode(',', [$np[0], $np[1]]);

                $ends[$zid + 1] ??= [];
                if ($input[$np[0]][$np[1]] == 9 && !in_array($newtrack, $ends[$zid + 1])) {
                    $ends[$zid + 1][] = $newtrack;
                    continue;
                }

                $q->insert([[$np[0], $np[1]], $newtrack]);
            }
        }
    }

    return array_sum(array_map('count', $ends));
}

include __DIR__ . '/template.php';
