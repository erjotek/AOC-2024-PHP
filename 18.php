<?php

function input($input)
{
    $lines = explode("\n", $input);

    return $lines;
}

function part1($input)
{
    $steps = path($input, 1024);

    return $steps; // 348
}

function part2($input)
{
    for ($xxx = 1024; $xxx <= count($input) - 1; $xxx++) {
        $steps = path($input, $xxx);

        if ($steps === 10000000) {
            break;
        }
    }

    return $input[$xxx - 1]; //54,44
}

function path($input, int $limit)
{
    $gridx = 70;
    for ($i = 0; $i <= $gridx; $i++) {
        for ($j = 0; $j <= $gridx; $j++) {
            $grid[$i][$j] = '.';
        }
    }

    foreach ($input as $id => $line) {
        [$col, $row] = explode(",", $line);
        $grid[$row][$col] = '#';
        if ($id == $limit - 1) {
            break;
        }
    }

    $q = new SplQueue();
    $q->enqueue([0, 0, 0]);

    $dirs = [[-1, 0], [1, 0], [0, -1], [0, 1]];

    $steps = 10000000;

    $visited = [];
    while (!$q->isEmpty()) {
        $pos = $q->dequeue();

        if ($pos[0] === $gridx && $pos[1] === $gridx) {
            $steps = min($steps, $pos[2]);
            break;
        }

        foreach ($dirs as $dir) {
            $newpos = [$pos[0] + $dir[0], $pos[1] + $dir[1]];

            if (isset($grid[$newpos[0]][$newpos[1]])
                && $grid[$newpos[0]][$newpos[1]] == '.'
                && !isset($visited[$newpos[0]][$newpos[1]])
            ) {
                $visited[$newpos[0]][$newpos[1]] = true;

                $q->enqueue([$newpos[0], $newpos[1], $pos[2] + 1]);
            }
        }
    }

    return $steps;
}

include __DIR__ . '/template.php';
