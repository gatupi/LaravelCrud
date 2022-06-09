<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinhaController extends Controller
{
    //
    public function getAllProducts(){
        return array('Vídeo-game', 'Notebook', 'Smartphone', 'Headset');
    }

    public function goodMorning() {
        return '<h1 style="width: 300px; background: lightblue; color: #333; margin: 30px auto; text-align: center;">Good Morning!</h1>';
    }

    public function mathOp(int $number1, int $number2, string $operator){
        $result;
        switch($operator){
            case "+":
                $result = $number1 + $number2;
                break;
            case "-":
                $result = $number1 - $number2;
                break;
            case "*":
                $result = $number1 * $number2;
                break;
            case ":":
                $result = $number1 / $number2;
                break;
        }
        return '<h1 style="width: 300px; background: lightblue; color: #333; margin: 30px auto; text-align: center;">Resultado é: ' . $result . '</h1>';
    }
}
