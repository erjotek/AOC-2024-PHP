<?php

function input($input)
{
    $inp3ut = <<<TEST
###############
#...#...#.....#
#.#.#.#.#.###.#
#S#...#.#.#...#
#######.#.#.###
#######.#.#...#
#######.#.###.#
###..E#...#...#
###.#######.###
#...###...#...#
#.#####.#.###.#
#.#...#.#.#...#
#.#.#.#.#.#.###
#...#...#...###
###############
TEST;

    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => str_split($l), $lines);

    return $lines;
}

function part1($input)
{
    $cheater = [];

    foreach ($input as $row => $line) {
        foreach ($line as $col => $char) {
            if ($char == 'S') {
                $start = [$row, $col];
                $input[$row][$col] = '.';
            }
            if ($char == 'E') {
                $end = [$row, $col];
                $input[$row][$col] = '.';
            }

            if ($char == '#' && $row > 0 && $row < count($input)-1 && $col > 0 && $col < count($input[0])-1) {
                $cheater[] = [$row, $col];
            }

        }
    }

//    print_r($cheater);



    $dirs = [[1, 0], [-1, 0], [0, 1], [0, -1]];

    $total = [];

    $oldInput = $input;
    foreach ($cheater as $xid => $xxx) {
        $input = $oldInput;
        $input[$xxx[0]][$xxx[1]] = '.';
        $q = new SplQueue();

        $q->enqueue([$start, 0, false]);
        $visited = [];
        while (!$q->isEmpty()) {
            [$pos, $steps, $cheat] = $q->dequeue();

            if ($pos[0] == $end[0] && $pos[1] == $end[1]) {
//                echo "KONIEC! w $steps\n";
                break;
            }

            if (isset($visited[$pos[0]][$pos[1]]) && $visited[$pos[0]][$pos[1]] < $steps) {
                continue;
            }

            if ($input[$pos[0]][$pos[1]] == 'E') {
                break;
            }

            $visited[$pos[0]][$pos[1]] = $steps;


            foreach ($dirs as $dir) {
                $newpos = [$pos[0] + $dir[0], $pos[1] + $dir[1]];

                if (isset($input[$newpos[0]][$newpos[1]]) && $input[$newpos[0]][$newpos[1]] == '.') {
                    $q->enqueue([$newpos, $steps + 1, $cheat]);
                }
            }
        }

        $total[$steps] ??= 0;
        $total[$steps]++;
//        echo "$xid  z ".count($cheater)."\n";
    }


    krsort($total);
    print_r($total);
    $max = max(array_keys($total));

    $sum = 0;
    foreach (array_keys($total) as $key) {
        if ($key < $max) {
            echo $total[$key]." cheats which saves ".($max-$key)."\n";
            if ($max -$key >= 100) {
                $sum += $total[$key];
            }
        }
    }
    return $sum;
}

function part2($input)
{
}


include __DIR__ . '/template.php';
