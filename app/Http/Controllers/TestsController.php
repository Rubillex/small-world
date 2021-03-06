<?php

namespace App\Http\Controllers;

use App\Models\Pictures;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\UserController;

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
        $tests = Test::all();
        $testsIdName = $tests->pluck('name', 'id');
        $testsComplited = $tests->mapWithKeys(function ($item, $key) {
            if (json_decode($item->userComplited) == null) return [$item['id'] => 'false'];
            if (in_array(Auth::id(), json_decode($item->userComplited))) {
                return [$item['id'] => 'true'];
            } else {
                return [$item['id'] => 'false'];
            }
        });

        return view('listOfLevels', ['data' => ['levelData' => $tests, 'complited' => $testsComplited]]);
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
        $needHelp          = $test['needHelp'];
        $anwers            = array_merge($incorrect_answers, $correct_answers);
        shuffle($anwers);

        $currentUser = User::find(Auth::id());
        $currentComplexity = $currentUser->complexity;

        $userLifes = User::find(Auth::id())->lifes;

        return view('levelAnswers', [
            'data' => [
                'complexity'        => $currentComplexity,
                'levelId'           => $levelId,
                'points'            => $test['points'],
                'name'              => $test['name'],
                'question'          => $test['question'],
                'answers'           => $anwers,
                'needHelp'          => $needHelp,
                'userLifes'         => $userLifes,
                'incorrect_answers' => json_decode($test['incorrect_answers'], 1),
                'correct_answers'   => json_decode($test['correct_answers'], 1),
            ],
        ]);
    }

    /**
     * Присваивает тесту юзера который его выполнил
     */
    public function addUserToTestComplited($levelId, $points, $checkedAnswers) {
        $test = Test::where('id', $levelId)->first();
        $userId = Auth::id();
        // Если тест без ручной проверки, то даём баллы
        if (!$test->needHelp){
            $answers = array_values(json_decode($checkedAnswers));
            $result = array_diff($answers,json_decode($test->correct_answers));
            if (count($result) === 0){
                $result = $this->changePoints($points);
            } else {
                $result = $this->changePoints(0);
            }
        }
        $usersComplited = json_decode($test->userComplited, 1);
        if ($usersComplited === null) {
            $test->userComplited = json_encode([$userId]);
        } else {
            $usersComplited[] = $userId;
            $test->userComplited = json_encode($usersComplited);
        }
        $test->save();
        return $result;
    }

    /**
     * Изменяет количество очков, если ответ верный или декрементит количество жизней, если ответ не верный
     *
     * @param $points
     */
    protected function changePoints($points) {
        $user = User::find(Auth::id());
        $lifes = $user->lifes;
        if ($points === 0) {
            $lifes = $user->lifes - 1;
            (new UserController)->changeLifes($lifes);
            return [
                'result'    => false,
                'userLifes' => $lifes,
                'points'    => $user->points,
            ];
        }
        $add_points = 0;
        switch ($user->complexity){
            case 1:
                // Низкий уровень сложности
                $add_points = $points * config('app.complexity_1');
                break;
            case 2:
                // Средний уровень сложности
                $add_points = $points * config('app.complexity_2');
                break;
            case 3:
                // Высокий уровень сложности
                $add_points = $points * config('app.complexity_3');
                break;
        }
        $user->points = $user->points + $add_points;
        if ($user->points > $user->score) $user->score = $user->points;
        $user->save();
        return [
            'result'    => true,
            'userLifes' => $lifes,
            'points'    => $user->points,
            'add_points'=> $add_points,
        ];
    }

    public function uploadFile(Request $request, $testId) {

        $path = $request->file('image')->store('images', 'public');
        $picture = Pictures::create();
        $currentUser = User::find(Auth::id());
        $picture->user_id = $currentUser->id;
        $picture->path_to_picture = $path;
        $picture->test_id = $testId;
        $picture->save();
    }
}
