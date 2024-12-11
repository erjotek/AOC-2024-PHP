<?php

function input($input)
{
    return str_split($input, 2);
}

function part1($input)
{
    return defrag($input, false); //6398608069280
}

function part2($input)
{
    return defrag($input, true); //6427437134372
}

function defrag($input, bool $part2): int
{
    $disk = [];

    $id = 0;
    $pos = 0;
    foreach ($input as $f) {
        $disk["f$id"] = [$f[0], $f[1] ?? 0, [], $pos];
        $id++;
        $pos += $f[0] + ($f[1] ?? 0);
    }

    foreach (array_reverse($disk) as $fid => $fromEnd) {
        foreach ($disk as $pid => &$place) {
            if ($fid == $pid) {
                break;
            }

            if ($place[1] === 0) {
                continue;
            }

            if ($place[1] >= $fromEnd[0]) {
                $place[1] -= $fromEnd[0];
                $place[2][] = [$fid, $fromEnd[0]];

                if ($part2) {
                    $disk[$fid][1] = 0;
                    $disk[$fid][3] += $disk[$fid][0];
                    $disk[$fid][0] = 0;
                } else {
                    unset($disk[$fid]);
                }
                break;
            }

            if (!$part2) {
                $disk[$fid][0] -= $place[1];
                $fromEnd[0] -= $place[1];
                $place[2][] = [$fid, $place[1]];
                $place[1] = 0;
            }
        }
        unset($place);

        if ($fromEnd[0] === 0) {
            break;
        }
    }

    $sum = 0;

    foreach ($disk as $fid => $file) {
        $id = $file[3];

        for ($i = 0; $i < $file[0]; $i++) {
            $sum += substr($fid, 1) * $id;

            $id++;
        }

        foreach ($file[2] ?? [] as $addfile) {
            for ($i = 0; $i < $addfile[1]; $i++) {
                $sum += substr($addfile[0], 1) * $id;

                $id++;
            }
        }
    }

    return $sum;
}

include __DIR__ . '/template.php';
