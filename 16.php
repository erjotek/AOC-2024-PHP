<?php

$sits = [];

function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => str_split($l), $lines);

    return $lines;
}

function part1($map)
{
    $dirs = [[0, 1], [1, 0], [0, -1], [-1, 0]];

    foreach ($map as $row => $cols) {
        foreach ($cols as $col => $char) {
            if ($char === "S") {
                $start = [$row, $col];
                $map[$row][$col] = '.';
            }

            if ($char === "E") {
                $end = [$row, $col];
                $map[$row][$col] = '.';
            }
        }
    }

    $queue = new SplPriorityQueue();
    $queue->insert([$start, [], 0, 0], 0);

    $visited = [];
    $best = [];
    while (!$queue->isEmpty()) {
        [$pos, $steps, $dir, $cost] = $queue->extract();


        if (isset($visited[$pos[0]][$pos[1]][$dir]) && $visited[$pos[0]][$pos[1]][$dir] < $cost) {
            continue;
        }

        if ($pos[0] == $end[0] && $pos[1] == $end[1]) {
            foreach ($steps as $step) {
                $best[$cost][implode(',',$step)] = true;
            }
        }

        $visited[$pos[0]][$pos[1]][$dir] = min($cost, $visited[$pos[0]][$pos[1]][$dir] ?? $cost);

        $newpos = [$pos[0] + $dirs[$dir][0], $pos[1] + $dirs[$dir][1]];

        if ($map[$newpos[0]][$newpos[1]] === '.') {
            $newcost = $cost + 1;
            $queue->insert([$newpos, [...$steps, $newpos], $dir, $newcost], -$newcost);
        }

        for ($i = 1; $i < 4; $i++) {
            if ($i == 1) {
                $newcost = $cost + 1001;
            }

            if ($i == 2) {
                $newcost = $cost + 2001;
            }

            if ($i == 3) {
                $newcost = $cost + 1001;
            }

            $dir = (++$dir) % 4;

            $newpos = [$pos[0] + $dirs[$dir][0], $pos[1] + $dirs[$dir][1]];

            if ($map[$newpos[0]][$newpos[1]] === '.') {
                $queue->insert([$newpos, [...$steps, $newpos], $dir, $newcost], -$newcost);
            }
        }
    }

    $min = min($visited[$end[0]][$end[1]]);
    global $sits;
    $sits =  count($best[$min])+1;

    return  $min; // 72428
}

function part2($input)
{
    global $sits;
    return $sits; // 456
}


include __DIR__ . '/template.php';
