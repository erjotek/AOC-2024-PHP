<?php

$memo = [];
function input($input)
{
    $lines = explode("\n\n", $input);
    $lines[0] = explode(", ", $lines[0]);
    usort($lines[0], fn($a, $b) => strlen($a) <=> strlen($b));
    $lines[1] = explode("\n", $lines[1]);

    return $lines;
}

function part1($input)
{
    $sum = 0;
    foreach ($input[1] as $towel) {
        $sum += checkTowel($input[0], $towel) ? 1: 0;
    }

    return $sum; //267
}

function part2($input)
{
    $sum = 0;
    foreach ($input[1] as $towel) {
        $sum += checkTowel($input[0], $towel);
    }
    return $sum; //796449099271652
}

function checkTowel(array $options, string $towel)
{
    global $memo;
    $total = 0;

    if (isset($memo[$towel])) {
        return $memo[$towel];
    }

    foreach ($options as $mark) {
        if (str_starts_with($towel, $mark)) {
            $newlist = substr($towel, strlen($mark));

            if ($newlist === '') {
                $total++;
                continue;
            }

            $newlist = checkTowel($options, $newlist);

            if ($newlist === false) {
                continue;
            }

            $total += $newlist;
        }
    }

    $memo[$towel] ??= $total;

    return $total;
}

include __DIR__ . '/template.php';
