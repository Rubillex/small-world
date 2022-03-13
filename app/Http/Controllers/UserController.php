<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Присваивает сложность пользователю
     */
    public function changeComplexity($complexity) {
            $user =  User::find(Auth::id());
            $user->complexity = $complexity;
            $user->save();

            return ['success' => true];
    }

    /**
     * Получить список уровней
     */
    public function getlevels(){
        $Tests = Test::all();
        if (!$Tests) return json_encode(['error' => 'list of levels is empty']);
        foreach ($Tests as $test){
            $answer[] = $test->id;
        }

        return json_encode(['answer' => json_encode($answer)]);
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
