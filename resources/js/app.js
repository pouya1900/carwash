/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import {createApp} from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import login from './components/login.vue';
import weekTimes from './components/weekTimes.vue';
import timetable from './components/timetable.vue';
import timetableMobile from './components/timetableMobile.vue';
import changeAvatar from './components/changeAvatar.vue';
import Uploader from './components/vue-media-upload.vue';
import videoPreview from './components/videoPreview.vue';
import imagePreview from './components/imagePreview.vue';
import changeMobile from './components/changeMobile.vue';
import addService from './components/addService.vue';

app.component('week-times', weekTimes);
app.component('timetable', timetable);
app.component('timetable-mobile', timetableMobile);
app.component('change-avatar', changeAvatar);
app.component('upload-media', Uploader);
app.component('video-input-preview', videoPreview);
app.component('image-input-preview', imagePreview);
app.component('login', login);
app.component('change-mobile', changeMobile);
app.component('add-service', addService);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
