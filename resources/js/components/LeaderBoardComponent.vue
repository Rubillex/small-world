ё<template>
    <div class="page-content">
        <div class="content">
            <div class="content__top">
                <div class="content__top-button">
                    На главную
                </div>
                <div class="content__top-button">
                    Выйти
                </div>
            </div>
            <div class="content__card">
                <p class="content__card__name">
                    Имя котёнка
                </p>
                <div class="content__card__column">
                    <div class="content__card__column__left">
                        <img class="content__card__column__left__img" src="/images/leader_cat.svg" alt="а котека то нет">
                        <div class="content__card__column__left__userLifes">
                            <img class="content__card__column__left__userLifes__img" src="/images/point_base.png" alt="а хп нет :(">
                            <img class="content__card__column__left__userLifes__img" src="/images/point_base.png" alt="а хп нет :(">
                            <img class="content__card__column__left__userLifes__img" src="/images/point_base.png" alt="а хп нет :(">
                        </div>
                    </div>
                    <div class="content__card__column__right">
                        <p class="content__card__column__right__points-title">
                            Мой счет
                        </p>
                        <p class="content__card__column__right__points-num">
                            15
                        </p>
                        <p class="content__card__column__right__leader-title">
                            Таблица лидеров
                        </p>
                        <div class="content__card__column__right__leader-board">
                            <div class="content__card__column__right__leader-board-content">
                                <div class="content__card__column__right__leader-board-content__circle">
                                    <div class="content__card__column__right__leader-board-content__circle__text">
                                        1
                                    </div>
                                </div>
                                <div class="content__card__column__right__leader-board-content__card">
                                    <div></div>
                                    <div class="content__card__column__right__leader-board-content__card__name">
                                        CatName
                                    </div>
                                    <div class="content__card__column__right__leader-board-content__card__points">
                                        150
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content__bottom">
                <button class="content__bottom-button">В ИГРУ!</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "leaderBoardComponent"
}
</script>

<style scoped>

</style>
