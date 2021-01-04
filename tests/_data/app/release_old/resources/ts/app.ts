import axios from 'axios';
import components from './components';
import {createApp} from 'vue';
import icons from './icons';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const app = createApp({});

app.use(components);
app.use(icons);

app.mount('#app');
