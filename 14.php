<?php

function input($input)
{
    $inp3ut = <<<TEST
p=0,4 v=3,-3
p=6,3 v=-1,-3
p=10,3 v=-1,2
p=2,0 v=2,-1
p=0,0 v=1,3
p=3,0 v=-2,-2
p=7,6 v=-1,-3
p=3,0 v=-1,-2
p=9,3 v=2,3
p=7,3 v=-1,2
p=2,4 v=2,-3
p=9,5 v=-3,-3
TEST;

    $in2put = <<<TEST
p=2,4 v=2,-3
TEST;


    $lines = explode("\n", $input);

    $robots = [];
    foreach ($lines as $line) {
        preg_match('~p=(?<px>\d+),(?<py>\d+) v=(?<vx>-?\d+),(?<vy>-?\d+)~', $line, $ret);
        $robots[] = $ret;
    }

    return $robots;
}

function part1($robots)
{
    //101 tiles wide and 103 tiles tall

    //11 tiles wide and 7 tiles tall



    $steps = 100;
    $cols = 101; $rows = 103;


    $tiles = [];
    foreach ($robots as $rid => $robot) {
        $rpx = $robot['px'];
        $rpy = $robot['py'];
        $tiles[$rpy][$rpx][$rid] = $rid;
    }

//    $steps = 10000;
    for ($s = 0; $s < $steps; $s++) {
//        foreach ($tiles as $line) {
//            if (count($line) >= 30) {
////            echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
//                echo "$s\n";
//                display($tiles, $rows, $cols);
//                usleep(50000);
//                break;
//            }
//        }

        foreach ($robots as $rid => &$robot) {
            $nx = ($robot['px'] + $robot['vx'] + $cols) % $cols;
            $ny = ($robot['py'] + $robot['vy'] + $rows) % $rows;

            unset($tiles[$robot['py']][$robot['px']][$rid]);
            if (empty($tiles[$robot['py']][$robot['px']])) {
                unset($tiles[$robot['py']][$robot['px']]);
            }

            $robot['px'] = $nx;
            $robot['py'] = $ny;

            $tiles[$ny][$nx][$rid] = $rid;

        }
        unset($robot);
    }

    $q = [];

    for ($r = 0; $r < $rows; $r++) {
        for ($c = 0; $c < $cols; $c++) {
            if ($c == ($cols-1)/2) {
                continue;
            }

            if ($r == ($rows-1)/2) {
                continue;
            }

            if ($c < floor($cols/2)) {
                $cc =0;

            } else {
                $cc = 1;
            }

            if ($r < $rows/2) {
                $rr =0;
            } else {
                $rr = 1;
            }

//            echo "$r,$c = $rr, $cc\n";
            $q["$rr,$cc"]  ??=0;
            $q["$rr,$cc"] += count($tiles[$r][$c] ?? []);
        }
    }

    return array_product($q); //218433348
}

function part2($input)
{
    return 6512;
}

function display($robots, $rows, $cols) {
    for ($r = 0; $r < $rows; $r++) {
        for ($c = 0; $c < $cols; $c++) {
            $count = count($robots[$r][$c] ?? []);
            if ($count) {
                echo "#";
            } else {
                echo ".";
            }
//             echo i ?: '.';
        }
        echo "\n";
    }

    echo "\n\n";
}

include __DIR__ . '/template.php';
