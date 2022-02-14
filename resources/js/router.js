/**
 * User: Rubillex
 * Date: 14.02.2022 9:21
 */

import VueRouter from 'vue-router';

import Vue from 'vue';
import TemplateComponent from "./components/TemplateComponent";
import StartGame from "./components/StartGame";

Vue.use(VueRouter);

const router =  [
        {
            path: '/',
            name: 'main-page',
            component: TemplateComponent
        },
        {
            path: '/start-game',
            name: 'start-game',
            component: StartGame
        }
    ];


export default new VueRouter({
    mode: 'history',
    routes: router
})
