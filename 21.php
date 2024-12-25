<?php

function input($input)
{
    $lines = explode("\n", $input);

    return $lines;
}

function part1($input)
{
   return calc($input, 3); // 222670
}

function part2($input)
{
    return calc($input, 26); //271397390297138
}

function calc($input, $steps) {
    $sum = 0;

    foreach ($input as $code) {
        $seqs1 = digitCode($code);
        $nseqs = [];
        foreach ($seqs1 as $sk => $sv) {
            $map = array_map(fn($a) => $a . 'A', explode("A", $sv));
            foreach ($map as $m) {
                $nseqs[$sk][$m] ??= 0;
                $nseqs[$sk][$m]++;
            }
        }

        $ns = newSeqs($steps, $nseqs)[0];
        $sum += (array_sum($ns)-1) * (int)$code;
    }

    return $sum;
}

function newSeqs(int $steps, $nseqs)
{
    for ($i = 0; $i<$steps; $i++) {
        $seqs2 = [];

        foreach ($nseqs as $seq1) {
            $seqs2[] = directCode($seq1);
        }

        $nseqs = $seqs2;
        $min = min(array_map('array_sum', $nseqs));
        $nseqs = array_filter($nseqs, fn($s) => array_sum($s) === $min);
    }

    return array_values($nseqs);
}

function digitCode($code)
{
    //+---+---+---+
    //| 7 | 8 | 9 |
    //+---+---+---+
    //| 4 | 5 | 6 |
    //+---+---+---+
    //| 1 | 2 | 3 |
    //+---+---+---+
    //    | 0 | A |
    //    +---+---+
    $digit = [
        '7' => [0, 0],
        '8' => [0, 1],
        '9' => [0, 2],
        '4' => [1, 0],
        '5' => [1, 1],
        '6' => [1, 2],
        '1' => [2, 0],
        '2' => [2, 1],
        '3' => [2, 2],
        '0' => [3, 1],
        'A' => [3, 2],
    ];

    $len = strlen($code);

    $seqs = [''];

    for ($i = 0; $i < $len; $i++) {
        $last = $digit[$code[$i - 1]] ?? 'A';
        $new = $digit[$code[$i]];
        $diff = [$new[0] - $last[0], $new[1] - $last[1]];

        $opts = [];
        $warn = '';
        if ($diff[1] < 0) {
            $opts[] = str_repeat('<', -$diff[1]);
            if ([$last[0], $last[1] + $diff[1]] === [3, 0]) {
                $warn = str_repeat('<', -$diff[1]);
            }
        }

        if ($diff[1] > 0) {
            $opts[] = str_repeat('>', $diff[1]);
        }

        if ($diff[0] < 0) {
            $opts[] = str_repeat('^', -$diff[0]);
        }

        if ($diff[0] > 0) {
            $opts[] = str_repeat('v', $diff[0]);
            if ([$last[0] + $diff[0], $last[1]] === [3, 0]) {
                $warn = str_repeat('v', $diff[0]);
            }
        }

        $newseqs = [];
        foreach ($seqs as $seq) {
            if (count($opts) == 2) {
                if ($warn !== $opts[0]) {
                    $newseqs[] = $seq . $opts[0] . $opts[1] . "A";
                }
                if ($warn !== $opts[1]) {
                    $newseqs[] = $seq . $opts[1] . $opts[0] . "A";
                }
            } else {
                $newseqs[] = $seq . $opts[0] . 'A';
            }
        }
        $seqs = $newseqs;
    }

    return $seqs;
}

function directCode($codes)
{
    $direct = [
        '^' => [0, 1],
        'A' => [0, 2],
        '<' => [1, 0],
        'v' => [1, 1],
        '>' => [1, 2],
    ];

    //    +---+---+
    //    | ^ | A |
    //+---+---+---+
    //| < | v | > |
    //+---+---+---+

    $comp['A<'] = 'v<<';
    $comp['<A'] = '>>^';

    $comp['Av'] = '<v';
    $comp['vA'] = '^>';

    $comp['^<'] = 'v<';
    $comp['<^'] = '>^';

    $comp['^>'] = 'v>';
    $comp['>^'] = '<^';


    $seqs = [];
    foreach ($codes as $code => $ile) {
        $len = strlen($code);

//        echo "robie $code \n";

        for ($i = 0; $i < $len; $i++) {
            $last = $direct[$code[$i - 1]] ?? 'A';
            $new = $direct[$code[$i]];

            $diff = [$new[0] - $last[0], $new[1] - $last[1]];

            $part = [];

            if ($diff[0] != 0 && $diff[1] != 0) {
                $opt =$code[$i - 1].$code[$i];

                $part[] = ($comp[$opt]);

//                if ($diff[1] < 0) {
//                    $part[] = str_repeat('<', -$diff[1]);
//                }
//                if ($diff[0] < 0) {
//                    $part[] = str_repeat('^', -$diff[0]);
//                }
//                if ($diff[0] > 0) {
//                    $part[] = str_repeat('v', $diff[0]);
//                }
//                if ($diff[1] > 0) {
//                    $part[] = str_repeat('>', $diff[1]);
//                }
            } else {
                if ($diff[1] < 0) {
                    $part[] = str_repeat('<', -$diff[1]);
                }

                if ($diff[1] > 0) {
                    $part[] = str_repeat('>', $diff[1]);
                }
                if ($diff[0] > 0) {
                    $part[] = str_repeat('v', $diff[0]);
                }

                if ($diff[0] < 0) {
                    $part[] = str_repeat('^', -$diff[0]);
                }
            }
            $blebla = implode('', $part) . 'A';
            $seqs[$blebla] ??= 0;
            $seqs[$blebla] += $ile;
        }
    }

    return $seqs;
}

include __DIR__ . '/template.php';
