<?php

namespace App\Orchid\Screens\Tests;

use App\Models\Test;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

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
            ModalToggle::make('Новый тест')->modal('createTest')->icon('brush')

        ];
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
                Quill::make('brefing')
                    ->title('Брифинг')
                    ->popover('Заполнять как текст, будет отображен в начале уровня'),
                Input::make('answers')->required()->title('Ответы'),
                Input::make('points')->required()->title('Количество очков за тест'),
            ]))->title('Создаем тест')
                ->applyButton('Создать')
                ->closeButton('Закрыть')
                ->size(Modal::SIZE_LG),

            Layout::table('tests', [
                TD::make('id', 'ID'),

                TD::make('name', 'Название')
                    ->width('450')
                    ->render(function (Repository $model) {
                        return Str::limit($model->get('name'), 200);
                    }),

                TD::make('points', 'Количество очков за тест')
                    ->width('350')
                    ->render(function (Repository $model) {
                        return Str::limit($model->get('name'), 200);
                    }),

                TD::make('created_at', 'Когда создан'),
            ]),
        ];
    }
}
