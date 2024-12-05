<?php

function input($input)
{
    $in3put = <<<TEST
47|53
97|13
97|61
97|47
75|29
61|13
75|53
29|13
97|29
53|29
61|53
97|53
61|29
47|13
75|47
97|75
47|61
75|61
47|29
75|13
53|13

75,47,61,53,29
97,61,53,29,13
75,29,13
75,97,47,61,53
61,13,29
97,13,75,29,47
TEST;

    $lines = explode("\n\n", $input);


    $ruleslist = array_map(fn($l) => explode('|', $l), explode("\n", $lines[0]));
    $pages = array_map(fn($l) => explode(',', $l), explode("\n", $lines[1]));

    $rules = [];
    foreach ($ruleslist as $rule) {
        $rules[$rule[0]][$rule[1]] = true;
    }

    return [$rules, $pages];
}

function part1($input)
{
    [$rules, $pages] = $input;

    $sum = 0;

    foreach ($pages as $page) {
        $valid = true;
        $c = count($page);
        for ($i = 1; $i < $c; $i++) {
            if (isset($rules[$page[$i]])) {
                for ($j = 0; $j < $i; $j++) {
                    if (isset($rules[$page[$i]][$page[$j]])) {
                        $valid = false;
                        break 2;
                    }
                }
            }
        }

        if ($valid) {
            $sum += $page[floor(count($page) / 2)];
        }
    }

    return $sum; //5639
}

function part2($input)
{
    [$rules, $pages] = $input;

    $sum = 0;
    foreach ($pages as $page) {
        $c = count($page);
        $valid = true;
        for ($i = 1; $i < $c; $i++) {
            if (isset($rules[$page[$i]])) {
                for ($j = 0; $j <= $i; $j++) {
                    if (isset($rules[$page[$i]][$page[$j]])) {
                        $valid = false;
                        $tmp = $page[$j];
                        $page[$j] = $page[$i];
                        $page[$i] = $tmp;
                        $i = 1;
                        break;
                    }
                }
            }
        }

        if (!$valid) {
            $sum += $page[floor(count($page) / 2)];
        }
    }

    return $sum; //5273
}

include __DIR__ . '/template.php';
