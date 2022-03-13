<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

/**
 * Отвечает за работу с тестами.
 */
class TestsController extends Controller
{
    /**
     * Получить список уровней
     */
    public function getlevels(){
        $tests = Test::all()->pluck('name', 'id');

        return json_encode(['answer' => json_encode($tests)]);
    }

    /**
     * Получить информацию о выбранном уровне
     * @param $levelId
     */
    public function getLevelData($levelId){
        $test = Test::where('id', $levelId)->first();
        if (!$test) return json_encode(['error' => 'Level not found']);

        $answer['id'] = $test->id;
        $answer['name'] = $test->name;
        $answer['brefing'] = $test->brefing;
        $answer['question'] = $test->question;
        $answer['incorrect_answers'] = $test->incorrect_answers;
        $answer['correct_answers'] = $test->correct_answers;
        $answer['points'] = $test->points;
        $help = ($test->needHelp === true)? 1 : 0;
        $answer['needHelp'] = $help;
        return json_encode(['answer' => json_encode($answer)]);
    }
}
