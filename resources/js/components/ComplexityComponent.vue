<template>
    <div class="template-page">
        <nav-menu></nav-menu>
        <div class="complexety-change">
            <div class="page-content">
                <h1 class="content-header"><b>Выбери котика-инженера!</b></h1>
                <div class="content-header__text-wrapper">
                    <p class="content-header__text">Выбирая себе компаньона помни, что от него напрямую зависит
                        сложность
                        прохождения игры и количество набранных за правильные ответы баллов. Внимательно ознакомься с <a href="#regulations">правилами игры.</a></p>
                </div>
                <div class="difficult">
                    <div class="difficult-wrapper">
                        <button v-bind:class="{ active: active === 1 }" v-on:click="changeDifficult(1)" class="difficult__button start">
                    <span class="difficult__button-content">
                        <span class="difficult__button-header">Начинающий</span>
                        <span class="difficult__button-text">Этот котик только начинает свой путь в&nbsp;энергетике, поэтому у&nbsp;него есть целых три попытки!</span>
                        <span class="difficult__life-block">
                            <img class="difficult__life" src="images/point_base.png" alt="жызнь"/>
                            <img class="difficult__life" src="images/point_base.png" alt="жызнь"/>
                            <img class="difficult__life" src="images/point_base.png" alt="жызнь"/>
                        </span>
                    <img class="difficult__cat" src="images/evrika_base.png" alt="кит"/>
                </span>
                        </button>
                        <button v-bind:class="{ active: active === 2 }" v-on:click="changeDifficult(2)" class="difficult__button medium">
                    <span class="difficult__button-content">
                        <span class="difficult__button-header">Продвинутый</span>
                        <span class="difficult__button-text">Если веришь в&nbsp;свои силы, то&nbsp;тебе сюда.
Обрати внимание, у&nbsp;тебя всего две попытки!</span>
                        <span class="difficult__life-block">
                            <img class="difficult__life" src="images/life_cool.png" alt="жызнь"/>
                            <img class="difficult__life" src="images/life_cool.png" alt="жызнь"/>
                        </span>
                    <img class="difficult__cat" src="images/evrika_cool.png" alt="кит"/>
                    </span>
                        </button>
                        <button v-bind:class="{ active: active === 3 }" v-on:click="changeDifficult(3)" class="difficult__button hard">
                    <span class="difficult__button-content">
                        <span class="difficult__button-header">Эксперт</span>
                        <span class="difficult__button-text">Вау! Игра с&nbsp;экспертом по&nbsp;энергетике&nbsp;&mdash; это вызов всему миру. У&nbsp;тебя нет права на&nbsp;ошибку...</span>
                        <span class="difficult__life-block">
                            <img class="difficult__life" src="images/life_cosmo.png" alt="жызнь"/>
                        </span>
                        <img class="difficult__cat" src="images/evrika_cosmo.png" alt="кит"/>
                    </span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="rules">
                <div class="rules__wrapper" id="regulations">
                    <h1 class="rules__header">Правила игры</h1>
                    <div class="rules__text-wrapper">
                        <p class="rules__text">Твоя главная задача набрать как можно больше баллов. Их&nbsp;можно
                            заработать
                            отвечая на&nbsp;вопросы, каждый из&nbsp;которых составлен согласно небольшому конспекту. Чем
                            лучше ты&nbsp;изучишь предложенную информацию, тем выше вероятность ответить верно.</p>
                        <p class="rules__text">Чтобы заработать больше баллов выбирай более высокую сложность. Однако,
                            чем
                            выше уровень сложности, тем меньше у&nbsp;тебя жизней (актуальное количество отмечается
                            сердечками в&nbsp;твоём профиле). Как только сердечки закончатся баллы обнулятся, а&nbsp;путь
                            придётся начинать сначала.</p>
                    </div>
                    <h2 class="rules__header secondary">Структура подсчёта баллов</h2>
                    <p class="rules__text">Ниже указаны коэффициенты умножения набранных за правильный ответ очков.</p>
                    <div class="rules__lifes-wrapper">
                        <div class="rules__lifes">
                            <div class="rules__life-content">
                                <div class="rules__life-item">
                                    <div class="rules__life-wrapper">
                                        <img class="rules__life-small" src="images/point_base.png" alt="жызнь"/>
                                        <img class="rules__life-small" src="images/point_base.png" alt="жызнь"/>
                                        <img class="rules__life-small" src="images/point_base.png" alt="жызнь"/>
                                    </div>
                                    <p class="rules__modificator">x 1</p>
                                    <p class="rules__modificator-label">(начинающий)</p>
                                </div>
                                <div class="rules__life-item">
                                    <div class="rules__life-wrapper">
                                        <img class="rules__life" src="images/life_cool.png" alt="жызнь"/>
                                        <img class="rules__life" src="images/life_cool.png" alt="жызнь"/>
                                    </div>
                                    <p class="rules__modificator">x 1.2</p>
                                    <p class="rules__modificator-label">(продвинутый)</p>
                                </div>
                                <div class="rules__life-item">
                                    <div class="rules__life-wrapper">
                                        <img class="rules__life" src="images/life_cosmo.png" alt="жызнь"/>
                                    </div>
                                    <p class="rules__modificator">x 1.5</p>
                                    <p class="rules__modificator-label">(эксперт)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="rules__text">Таким образом, пример получения баллов за&nbsp;один и&nbsp;тот&nbsp;же
                        вопрос для разных уровней сложности может выглядеть так: стоимость вопроса&nbsp;&mdash; 5&nbsp;баллов,
                        уровень сложности&nbsp;&mdash; средний, итого баллов&nbsp;&mdash; 5*1.2 = 6.</p>
                    <div class="rules__ending">
                        <div class="rules__ending-wrapper">
                            <p class="rules__ending-text">Всё просто: копи баллы, учись и&nbsp;совершенствуйся!</p>
                            <button v-popover:foo.right v-on:click="goProfile()" class="rules__ending-button">Я готов к игре</button>

                            <popover name="foo" :width="500" :delay="hidepopover ? 5000 : 200">
                                <div>Сначала выбери сложность!</div>
                            </popover>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavMenu from "./partials/Navmenu";
export default {
    name: "ComplexetyComponent",
    components: {NavMenu},

    data: () => {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            userDifficult: '',
            hidepopover: false,
            active: '',
        }
    },
    created() {
        this.userDifficult = '-1';
    },

    methods: {
        async goProfile() {
            if (this.userDifficult === '-1') {
                return;
            }

            await this.$router.push({path: '/profile'}).catch(()=>{});
            this.$router.go(0)
        },

        async changeDifficult(value) {
            this.active = value;
            await axios.post('/api/change-difficult/' + value)
                .catch(err => console.log(err));
            this.userDifficult = value;
            this.hidepopover = true;
        },
    }
}
</script>
