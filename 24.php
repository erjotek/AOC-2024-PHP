<?php

$regs = [];
$results = [];
$trace = [];

function input($input)
{
    $lines = explode("\n\n", $input);
    global $results;
    global $regs;

    $lines[1] = explode("\n", $lines[1]);
    foreach ($lines[1] as $line) {
        preg_match('/(\w+) (\w+) (\w+) -> (\w+)/', $line, $ret);
        $results[$ret[4]] = $ret;
    }


    $lines[0] = explode("\n", $lines[0]);
    foreach ($lines[0] as $line) {
        $line = explode(": ", $line);
        $regs[$line[0]] = (int)$line[1]; // name
    }


    return $lines;
}

function part1($input)
{
    return bindec(program()); //38869984335432
}

function part2($input)
{
    global $regs;

    for ($b = 44; $b >= 0; $b--) {
        $pref = '000000000000000000000000000000000000000000000';
        echo "b: " . (44 - $b) . "\n";

        $pref[$b] = 1;
        $regs = [];
        for ($i = 44; $i >= 0; $i--) {
            $regs["x" . sprintf('%02d', 44 - $i)] = (int)$pref[$i];
            $regs["y" . sprintf('%02d', 44 - $i)] = (int)$pref[$i];
//            $regs["y" . sprintf('%02d', 44 - $i)] = 1;
        }

        // 9,10      15,16      21,22
        //qjb, gvw,  z15,jgc,   drg,z22,  jbp,z35

        echo "X:  ";
        $x = '';
        for ($i = 0; $i <= 44; $i++) {
            $x .= $regs["x" . sprintf('%02d', 44 - $i)];
            echo $regs["x" . sprintf('%02d', 44 - $i)];
        }

        echo "\n";

        echo "Y:  ";
        $y = '';
        for ($i = 0; $i <= 44; $i++) {
            $y .= $regs["y" . sprintf('%02d', 44 - $i)];
            echo $regs["y" . sprintf('%02d', 44 - $i)];
        }

        echo "\n";

        $wyn = program();

        echo "Z: " . $wyn . "\n";
        if (bindec($wyn) !== bindec($x) + bindec($y)) {
            echo "ERR! \n\n";
        }

        echo "\n";
    }

    return; // drg,gvw,jbp,jgc,qjb,z15,z22,z35
}

function calc($result)
{
    global $regs;
    global $results;

    $val1 = $regs[$result[1]] ?? calc($results[$result[1]]);
    $val2 = $regs[$result[3]] ?? calc($results[$result[3]]);

    if ($result[2] === 'OR') {
        $regs[$result[4]] = $val1 | $val2;
        return $val1 | $val2;
    }

    if ($result[2] === 'AND') {
        $regs[$result[4]] = $val1 & $val2;
        return $val1 & $val2;
    }

    if ($result[2] === 'XOR') {
        $regs[$result[4]] = $val1 ^ $val2;
        return $val1 ^ $val2;
    }

    die('error');
}

function program()
{
    global $regs;
    global $results;

    foreach ($results as $result) {
        calc($result);
    }

    $bit = '';
    krsort($regs);
    foreach ($regs as $regname => $regval) {
        if (str_starts_with($regname, 'z')) {
            $bit .= $regval;
        }
    }

    return $bit;
}


include __DIR__ . '/template.php';
