import Alpine from 'alpinejs';

import mask from '@alpinejs/mask' 
Alpine.plugin(mask)

import navbar from './components/navbar';
import sidebar from './components/sidebar';

Alpine.data('navbar', navbar);
Alpine.data('sidebar', sidebar);

Alpine.start();



