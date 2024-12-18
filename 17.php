<?php

function input($input)
{
    $lines = explode("\n\n", $input);

    return $lines;
}

function part1($input)
{
    $ret = runProgram($input);
    return implode(",", $ret); //2,1,4,0,7,4,0,2,3
}

function part2($input)
{
    $ins = explode(": ", $input[1]);
    $ins = array_map('intval', explode(",", $ins[1]));

    $start = 0;
    for ($nr = 1; $nr <= 16; $nr++) {
        for ($aa = $start * 8; $aa <= ($start+1) * 9; $aa++) {
            $ret = runProgram($input, $aa);

            if (array_slice($ins, -$nr) == $ret) {
                $start = $aa;
                break;
            }
        }
    }

    return $aa; //258394985014171

}

function runProgram($input, $aa = null)
{
    $ins = explode(": ", $input[1]);
    $ins = array_map('intval', explode(",", $ins[1]));

    $input[0] = explode("\n", $input[0]);

    $a = (int)explode(": ", $input[0][0])[1];
    $b = (int)explode(": ", $input[0][1])[1];
    $c = (int)explode(": ", $input[0][2])[1];

    if ($aa) {
        $a = $aa;
    }

    $combo = [0, 1, 2, 3, &$a, &$b, &$c, null];

    $i = 0;
    $imax = count($ins);

    $ret = [];

    while ($i < $imax) {
        $op = $ins[$i++];
        $arg = $ins[$i++];

        //adv
        if ($op == 0) {
            $a = floor($a / 2 ** $combo[$arg]);
        }

        // bxl xor
        if ($op == 1) {
            $b = $b ^ $arg;
        }

        // bst
        if ($op == 2) {
            $b = $combo[$arg] % 8;
        }

        //jnz
        if ($op == 3) {
            if ($a) {
                $i = $arg;
            }
        }

        // bxc xor
        if ($op == 4) {
            $b = $b ^ $c;
        }

        //out
        if ($op == 5) {
            $val = ($combo[$arg] % 8);
            $ret[] = $val;
        }

        //bdv
        if ($op == 6) {
            $b = floor($a / 2 ** $combo[$arg]);
        }

        //cdv
        if ($op == 7) {
            $c = floor($a / 2 ** $combo[$arg]);
        }
    }

    return $ret;
}

include __DIR__ . '/template.php';
