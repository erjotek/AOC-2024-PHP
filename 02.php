<?php

function input($input)
{
    $in3put = <<<TEST
7 6 4 2 1
1 2 7 8 9
9 7 6 2 1
1 3 2 4 5
8 6 4 4 1
1 3 6 7 9
TEST;

    return explode("\n", $input);
}

function part1($input)
{
    $ok = 0;

    foreach ($input as $line) {
        $line = explode(" ", $line);

        if (check($line)) {
            $ok++;
        }
    }

    return $ok; //463
}

function part2($input)
{
    $ok = 0;

    foreach ($input as $line) {
        $linecopy = explode(" ", $line);
        $limit = count($linecopy);

        $pos = -1;
        while ($pos < $limit) {
            $line = $linecopy;

            if ($pos > -1) {
                unset($line[$pos]);
                $line = array_values($line);
            }

            $pos++;

            if (check($line)) {
                $ok++;
                break;
            }
        }
    }

    return $ok; //514
}

function check($line) {
    $x = $line;
    $y = $line;

    sort($x);
    rsort($y);

    if ($line != $x && $line != $y) {
        return false;
    }

    $valid = true;
    for ($i = 0; $i < count($line)-1; $i++) {
        $d = abs($line[$i] - $line[$i+1]);
        if ($d < 1 || $d > 3) {
            $valid = false;
        }
    }

    return $valid;
}

include __DIR__ . '/template.php';
