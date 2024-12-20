<?php

$visited = [];
function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => str_split($l), $lines);

    return $lines;
}

function part1($input)
{
    foreach ($input as $row => $line) {
        foreach ($line as $col => $char) {
            if ($char === 'S') {
                $start = [$row, $col];
                $input[$row][$col] = '.';
            }
            if ($char === 'E') {
                $end = [$row, $col];
                $input[$row][$col] = '.';
            }
        }
    }

    $dirs = [[1, 0], [-1, 0], [0, 1], [0, -1]];

    global $visited;
    $q = new SplQueue();
    $q->enqueue([$start, 0, false]);

    while (!$q->isEmpty()) {
        [$pos, $steps, $cheat] = $q->dequeue();


        if (isset($visited[$pos[0]][$pos[1]]) && $visited[$pos[0]][$pos[1]] < $steps) {
            continue;
        }

        $visited[$pos[0]][$pos[1]] = $steps;

        if ($pos[0] == $end[0] && $pos[1] == $end[1]) {
            break;
        }

        foreach ($dirs as $dir) {
            $newpos = [$pos[0] + $dir[0], $pos[1] + $dir[1]];

            if (isset($input[$newpos[0]][$newpos[1]]) && $input[$newpos[0]][$newpos[1]] === '.') {
                $q->enqueue([$newpos, $steps + 1, $cheat]);
            }
        }
    }

    return countCheats(2);
}

function part2($input)
{
    return countCheats(20);
}

function countCheats(int $limit)
{
    global $visited;
    $cheats = [];

    foreach ($visited as $row => $data) {
        foreach ($data as $col => $steps) {
            for ($drow = $limit; $drow >= -$limit; $drow--) {
                for ($dcol = $limit; $dcol >= -$limit; $dcol--) {
                    $m = abs($dcol) + abs($drow);
                    if ($m > $limit) {
                        continue;
                    }

                    $neigh = [$row + $drow, $col + $dcol];

                    if (isset($visited[$neigh[0]][$neigh[1]]) && $visited[$neigh[0]][$neigh[1]] > $steps) {
                        $delta = $visited[$neigh[0]][$neigh[1]] - $steps - $m;
                        $cheats[$delta] ??= 0;
                        $cheats[$delta]++;
                    }
                }
            }
        }
    }

    $sum = 0;
    foreach ($cheats as $delta => $count) {
        if ($delta >= 100) {
            $sum += $count;
        }
    }

    return $sum;
}

include __DIR__ . '/template.php';
