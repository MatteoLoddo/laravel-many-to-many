import Vue from 'vue';
import FrontEnd from './FrontEnd.vue';

new Vue({

    el:'#app',
    render: h => h(FrontEnd)
})