<?php

function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => str_split($l), $lines);

    return $lines;
}

function part1($input)
{
    $visited = [];
    $areas = [];
    $dirs = [[1, 0], [-1, 0], [0, 1], [0, -1]];

    $id = 0;
    foreach ($input as $row => $line) {
        foreach ($line as $col => $char) {
            if (isset($visited[$row][$col])) {
                continue;
            }

            $id++;

            $q = new SplQueue();
            $q->enqueue([$row, $col]);

            $areas[$id] ??= ['a' => 0, 'p' => 0, 'pp' => [0, 0, 0, 0]];

            while (!$q->isEmpty()) {
                [$posr, $posc] = $q->dequeue();

                if (isset($visited[$posr][$posc])) {
                    continue;
                }

                $visited[$posr][$posc] = $id;

                $areas[$id]['a']++;

                foreach ($dirs as $di => [$dr, $dc]) {
                    [$nr, $nc] = [$posr + $dr, $posc + $dc];

                    if (isset($input[$nr][$nc]) && $input[$nr][$nc] == $char) {
                        $q->enqueue([$nr, $nc]);
                    } else {
                        $areas[$id]['p']++;
                    }
                }
            }
        }
    }

    return array_sum(array_map(fn($a) => $a['a'] * $a['p'], $areas)); //1450816
}


function part2($input)
{
    $visited = [];
    $areas = [];
    $borders = [];
    $dirs = ['b' => [1, 0], 't' => [-1, 0], 'r' => [0, 1], 'l' => [0, -1]];
    $dirs2 = ['tl' => [-1,-1], 'bl' => [1,-1], 'tr' => [-1,1], 'br' => [1,1]];

    $id = 0;
    foreach ($input as $row => $line) {
        foreach ($line as $col => $char) {
            if (isset($visited[$row][$col])) {
                continue;
            }

            $id++;

            $q = new SplQueue();
            $q->enqueue([$row, $col]);

            $areas[$id] ??= ['a' => 0, 'p' => 0];

            while (!$q->isEmpty()) {
                [$posr, $posc] = $q->dequeue();

                if (isset($visited[$posr][$posc])) {
                    continue;
                }

                $visited[$posr][$posc] = $id;
                $borders[$posr][$posc] = [];

                $areas[$id]['a']++;

                $c = [];
                foreach ($dirs as $di => [$dr, $dc]) {
                    [$nr, $nc] = [$posr + $dr, $posc + $dc];

                    if (isset($input[$nr][$nc]) && $input[$nr][$nc] == $char) {
                        $q->enqueue([$nr, $nc]);
                    } else {
                        $borders[$posr][$posc][$di] = $di;
                    }
                }

                foreach ($dirs2 as $di => [$dr, $dc]) {
                    [$nr, $nc] = [$posr + $dr, $posc + $dc];

                    if (isset($input[$nr][$nc]) && $input[$nr][$nc] == $char) {
                    } else {
                        $borders[$posr][$posc][$di] = $di;
                    }
                }
            }
        }
    }

    foreach ($borders as $row => $cols) {
        foreach ($cols as $col => $c) {
            $id = $visited[$row][$col];

            if (isset($c['t'], $c['l'])) {
                $areas[$id]['p']++;
            }

            if (!isset($c['t']) && !isset($c['l']) && isset($c['tl'])) {
                $areas[$id]['p']++;
            }




            if (isset($c['b'], $c['l'])) {
                $areas[$id]['p']++;
            }
            if (!isset($c['b']) && !isset($c['l']) && isset($c['bl'])) {
                $areas[$id]['p']++;
            }




            if (isset($c['b'], $c['r'])) {
                $areas[$id]['p']++;
            }

            if (!isset($c['b']) && !isset($c['r']) && isset($c['br'])) {
                $areas[$id]['p']++;
            }



            if (isset($c['t'], $c['r'])) {
                $areas[$id]['p']++;
            }

            if (!isset($c['t']) && !isset($c['r']) && isset($c['tr'])) {
                $areas[$id]['p']++;
            }
        }
    }

    return array_sum(array_map(fn($a) => $a['a'] * $a['p'], $areas)); //865662
}

include __DIR__ . '/template.php';
