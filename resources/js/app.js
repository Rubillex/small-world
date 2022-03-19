/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('template-component', require('./components/TemplateComponent.vue').default);
Vue.component('auth-component', require('./components/AuthComponent').default);
Vue.component('start-game-component', require('./components/StartGameComponent').default);
Vue.component('list-of-levels-component', require('./components/ListOfLevelsComponent').default);
Vue.component('level-component', require('./components/Level/LevelComponent').default);
Vue.component('question-component', require('./components/Level/QuestionsComponent').default);
Vue.component('leader-board-component', require('./components/LeaderBoardComponent').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import router from './router';

const app = new Vue({
    el: '#app',
    router
});
