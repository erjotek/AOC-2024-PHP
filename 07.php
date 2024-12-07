<?php

function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => explode(': ', $l), $lines);

    return $lines;
}

function part1($input)
{
    return calc($input, ['*', '+']); //3245122495150
}
function part2($input)
{
    return calc($input, ['*', '+', '|']); //105517128211543
}

function calc($input, array $opts): mixed
{
    $sum = 0;
    foreach ($input as $line) {
        [$result, $nums] = $line;

        $nums = explode(" ", $nums);

        $combinations = combine(count($nums) - 1, $opts);

        foreach ($combinations as $combination) {
            $small = $nums[0];
            foreach (str_split($combination) as $id => $opt) {
                if ($opt == '+') {
                    $small += $nums[$id + 1];
                }

                if ($opt == '*') {
                    $small *= $nums[$id + 1];
                }
                if ($opt == '|') {
                    $small .= $nums[$id + 1];
                }
            }
            if ($result == $small) {
                $sum += $result;
                break;
            }
        }
    }
    return $sum;
}

function combine($length, $opts)
{
    if ($length === 0) {
        return [''];
    }
    $result = [];
    foreach ($opts as $opt) {
        foreach (combine($length - 1, $opts) as $combination) {
            $result[] = $opt . $combination;
        }
    }
    return $result;
}

include __DIR__ . '/template.php';
