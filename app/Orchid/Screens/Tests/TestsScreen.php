<?php

namespace App\Orchid\Screens\Tests;

use App\Models\Test;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\SimpleMDE;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Request;

class TestsScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tests' => Test::all(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Тесты';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Новый тест')
                ->modal('createTest')
                ->icon('brush')
                ->method('createTest')
        ];
    }

    /**
     * Сохранение теста в БД
     */
    public function createTest(Request $request): void
    {
        $matrix = $request->matrix; //матрица ответов
        foreach ($matrix as $answer){//проверяем, если правильный, то в массив с правильными
            if ($answer['correct'] === '1')
                 $correct[] = $answer['answers'];
            else $incorrect[] = $answer['answers'];
        }
        $help = $request->needHelp === '1';//пыха даёт 1, вместо true, поэтому такая вот штука теперь живёт здесь
        Test::create([
            'name' => $request->name,
            'brefing' => $request->brefing,
            'question' => $request->question,
            'incorrect_answers' => json_encode($incorrect),
            'correct_answers' => json_encode($correct),
            'points' => $request->points,
            'needHelp' => $help,
        ]);//отправляем тест в БД
    }
    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::modal('createTest', Layout::rows([
                Input::make('name')->required()->title('Название'),
                SimpleMDE::make('brefing')
                    ->title('Брифинг')
                    ->toolbar(["text", "color", "header", "list", "format", "media"])
                    ->popover('Заполнять как текст, будет отображен в начале уровня'),
                SimpleMDE::make('question')
                    ->title('Вопрос'),
                Matrix::make('matrix')
                    ->columns([
                        'Ответ' => 'answers',
                        'Правильный' => 'correct',
                    ])
                    ->required()
                    ->fields([
                        'answers' => Input::make(),
                        'correct' => CheckBox::make()->sendTrueOrFalse(),
                    ]),
                Input::make('points')->required()->title('Количество очков за тест'),
                CheckBox::make('needHelp')->title('Требует проверки преподователя')->sendTrueOrFalse(),
            ]))->title('Создаем тест')
                ->applyButton('Создать')
                ->closeButton('Закрыть')
                ->size(Modal::SIZE_LG),

            Layout::table('tests', [
                TD::make('id', 'ID'),
                TD::make('name', 'Название')
                    ->width('450'),
                TD::make('points', 'Количество очков за тест')
                    ->width('350'),
                TD::make('needHelp', 'Ручная проверка')->render(function (Test $test) {
                    return match ($test->needHelp) {
                        1 => '✔',
                        default => '✖',
                    };
                }),

                TD::make('created_at', 'Когда создан'),
            ]),
        ];
    }
}
