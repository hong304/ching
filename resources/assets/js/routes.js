
//=============import vue packages=================
import VueRouter from 'vue-router';
window.VueTables = require('vue-tables-2');
import {ServerTable, ClientTable, Event} from 'vue-tables-2';
Vue.use(ClientTable);

//============import vue components================
const AdminBlog = resolve => {
    require.ensure(['./components/AdminBlog.vue'], () => {
        resolve(require('./components/AdminBlog.vue'));
    });
};

const AdminUser = resolve => {
    require.ensure(['./components/AdminUser.vue'], () => {
        resolve(require('./components/AdminUser.vue'));
    });
};

// vue components for user profile setting page
// import PersonalInformation from './components/profile/PersonalInformation.vue';
// import ChangePassword from './components/profile/ChangePassword.vue';
// import ChangeEmail from './components/profile/ChangeEmail.vue';


const router = new VueRouter({
    mode: 'history',
    routes: [
        // { path: '/video-player/:slug',
        //     component(resolve) {
        //     require.ensure(['./components/VideoPlayer.vue'], () => {
        //         resolve(require('./components/VideoPlayer.vue'));
        //     });
        // }},
        { path: '/admin/blog', component: AdminBlog },
        { path: '/admin/user', component: AdminUser },
        { path: '/admin/recipes', component: AdminBlog },
        { path: '/admin/videos', component: AdminBlog },
        // { path: '/profile/personal-information',
        //     component(resolve) {
        //         require.ensure(['./components/profile/PersonalInformation.vue'], () => {
        //             resolve(require('./components/profile/PersonalInformation.vue'));
        //         });
        //     }},
        // { path: '/profile/change-password',
        //     component(resolve) {
        //         require.ensure(['./components/profile/ChangePassword.vue'], () => {
        //             resolve(require('./components/profile/ChangePassword.vue'));
        //         });
        //     }},
        // { path: '/profile/change-email',
        //     component(resolve) {
        //         require.ensure(['./components/profile/ChangeEmail.vue'], () => {
        //             resolve(require('./components/profile/ChangeEmail.vue'));
        //         });
        //     }}
    ]
});

const app = new Vue({
    router
}).$mount('#app');