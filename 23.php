<?php

$back = [];
function input($input)
{
    $lines = explode("\n", $input);
    $lines = array_map(fn($l) => explode('-', $l), $lines);

    foreach ($lines as $pair) {
        $conns[$pair[0]][$pair[1]] = $pair[1];
        $conns[$pair[1]][$pair[0]] = $pair[0];
    }
    return $conns;
}

function part1($conns)
{
    $seqs = [];

    $keys = array_keys($conns);
    foreach ($keys as $one) {
        foreach ($keys as $two) {
            if ($two == $one) {
                continue;
            }
            foreach ($keys as $three) {
                if ($two == $three || $one == $three) {
                    continue;
                }
                if (isset($conns[$one][$two]) && isset($conns[$one][$three]) && isset($conns[$two][$three])) {
                    $key = [$one, $two, $three];
                    sort($key);
                    $key = implode(',', $key);
                    if (str_starts_with($key, 't') || str_contains($key, ',t')) {
                        $seqs[$key] = $key;
                    }
                }
            }
        }
    }

    return count($seqs); // 1119
}

function part2($conns)
{
    $min = 0;
    $last = [];
    foreach ($conns as $key => $conn) {
        $xxx = (find($conns, $key, [$key => $key]));
        if (count($xxx) > $min) {
            $min = count($xxx);
            $last = $xxx;
        }
    }

    sort($last);
    return implode(",", $last); // av,fr,gj,hk,ii,je,jo,lq,ny,qd,uq,wq,xc
}

function find($conns, $key, $was)
{
    foreach ($conns[$key] as $next) {
        if (!isset($was[$next])) {
            foreach ($was as $w) {
                if (!isset($conns[$next][$w])) {
                    continue 2;
                }
            }

            $newwas = $was;
            $newwas[$next] = $next;
            $was = find($conns, $next, $newwas);
        }
    }

    return $was;
}

include __DIR__ . '/template.php';
