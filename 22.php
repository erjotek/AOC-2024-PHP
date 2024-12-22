<?php

function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map('intval', $lines);

    return $lines;
}

function part1($input)
{
    $sum = 0;
    foreach ($input as $num) {
        for ($i = 0; $i < 2000; $i++) {
            $num = (($num * 64) ^ $num) % 16777216;
            $num = ((floor($num / 32)) ^ $num) % 16777216;
            $num = (($num * 2048) ^ $num) % 16777216;
        }
        $sum += $num;
    }
    return $sum; //19458130434
}

function part2($input)
{
    $seqs = [];

    foreach ($input as $id => $num) {
        unset($last);
        $window = [];

        for ($i = 0; $i <= 2000; $i++) {
            $new = $num % 10;
            if (isset($last)) {
                $window[] = $new - $last;
            }

            $last = $new;

            $num = (($num * 64) ^ $num) % 16777216;
            $num = ((floor($num / 32)) ^ $num) % 16777216;
            $num = (($num * 2048) ^ $num) % 16777216;

            if (count($window) === 4) {
                $seqs[implode(',', $window)][$id] ??= $new;
                array_shift($window);
            }
        }
    }

    return max(array_map('array_sum', $seqs)); // 2130
}

include __DIR__ . '/template.php';
