import {App} from 'vue';
import HelloWorld from './HelloWorld.vue';

export default {
    install(app: App): void {
        app.component('HelloWorld', HelloWorld);
    },
}
