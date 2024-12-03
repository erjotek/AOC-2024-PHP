<?php

function input($input)
{
    $input = str_replace("\n", " ", $input);
    preg_match_all(
        "~(don't\(\)|do\(\)|mul\((\d{1,3}),(\d{1,3})\))~",
        $input,
        $matches,
        PREG_SET_ORDER | PREG_UNMATCHED_AS_NULL
    );
    return $matches;
}

function part1($matches)
{
    $res = 0;

    foreach ($matches as $match) {
        $res += $match[2] * $match[3];
    }

    return $res; //190604937
}

function part2($matches)
{
    $res = 0;

    $do = true;
    foreach ($matches as $match) {
        if ($match[1] === 'do()') {
            $do = true;
        }

        if ($match[1] === "don't()") {
            $do = false;
        }

        if ($do) {
            $res += $match[2] * $match[3];
        }
    }

    return $res; //82857512
}

include __DIR__ . '/template.php';
