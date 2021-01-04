import { App } from 'vue';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {faBars} from '@fortawesome/free-solid-svg-icons';
import {library} from '@fortawesome/fontawesome-svg-core';

export default {
    install(app: App) {
        library.add(faBars);

        app.component('FaIcon', FontAwesomeIcon);
    },
}
