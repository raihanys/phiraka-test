<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FibonacciController extends Controller
{
    public function index(Request $request)
    {
        $rows = $request->input('rows', 0);
        $cols = $request->input('cols', 0);
        $data = [];

        if ($rows > 0 && $cols > 0) {
            $totalCells = $rows * $cols;
            $fib = [0, 1];
            for ($i = 2; $i < $totalCells; $i++) {
                $fib[] = $fib[$i - 1] + $fib[$i - 2];
            }
            $index = 0;
            for ($r = 0; $r < $rows; $r++) {
                for ($c = 0; $c < $cols; $c++) {
                    $data[$r][$c] = $fib[$index];
                    $index++;
                }
            }
        }
        return view('fibonacci', compact('data', 'rows', 'cols'));
    }
}
