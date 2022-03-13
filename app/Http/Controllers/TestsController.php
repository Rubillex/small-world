<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Отвечает за работу с тестами.
 */
class TestsController extends Controller
{
    /**
     * Возвращает страницу со списком уровней
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getlevels() {
        if (!Auth::check()) return view('index')->with('data', ['page' => 'index']);
        $tests = Test::all()->pluck('name', 'id');

        return view('listOfLevels', ['data' => ['levelData' => $tests]]);
    }

    /**
     * Получить информацию о выбранном уровне
     * @param $levelId
     */
    public function getLevelData($levelId){
        $test = Test::where('id', $levelId)->first();
        if (!$test) return json_encode(['error' => 'Level not found']);

        $answer['id']                = $test->id;
        $answer['name']              = $test->name;
        $answer['brefing']           = $test->brefing;
        $answer['question']          = $test->question;
        $answer['incorrect_answers'] = $test->incorrect_answers;
        $answer['correct_answers']   = $test->correct_answers;
        $answer['points']            = $test->points;
        $help                        = ($test->needHelp === true) ? 1 : 0;
        $answer['needHelp']          = $help;

        return $answer;
    }

    /**
     * Возвращает страницу с выбранным уровнем
     *
     * @param $levelId
     */
    public function goToLevel($levelId){
        $test = $this->getLevelData($levelId);

        return view('level', [
            'data' => [
                'levelId'  => $levelId,
                'name'     => $test['name'],
                'brefing'  => $test['brefing'],
                'needHelp' => $test['needHelp'],
                'points'   => $test['points'],
            ],
        ]);
    }

    /**
     * Возвращает страницу с ответом на выбранный выбранным уровнем
     *
     * @param $levelId
     */
    public function goToLevelAnswers($levelId) {
        $test              = $this->getLevelData($levelId);
        $incorrect_answers = json_decode($test['incorrect_answers'], 1);
        $correct_answers   = json_decode($test['correct_answers'], 1);
        $anwers            = array_merge($incorrect_answers, $correct_answers);
        shuffle($anwers);

        $userLifes = User::find(Auth::id())->lifes;

        return view('levelAnswers', [
            'data' => [
                'levelId'           => $levelId,
                'name'              => $test['name'],
                'question'          => $test['question'],
                'answers'           => $anwers,
                'userLifes'         => $userLifes,
                'incorrect_answers' => json_decode($test['incorrect_answers'], 1),
                'correct_answers'   => json_decode($test['correct_answers'], 1),
            ],
        ]);
    }

    /**
     * Присваивает тесту юзера который его выполнил
     */
    public function addUserToTestComplited($levelId) {
        $test = Test::where('id', $levelId)->first();
        $userId = Auth::id();

        $usersComplited = json_decode($test->userComplited, 1);
        if ($usersComplited === null) {
            $test->userComplited = json_encode([$userId]);
        } else {
            $usersComplited[] = $userId;
            $test->userComplited = json_encode($usersComplited);
        }
        $test->save();

        return true;
    }
}
