import './bootstrap';
import './frontend';

import Alpine from 'alpinejs';
import initializeTheme from './theme';

window.Alpine = Alpine;

initializeTheme(Alpine);
Alpine.start();
