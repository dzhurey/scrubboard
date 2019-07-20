/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

// Register $ global var for jQuery
import $ from 'jquery';
window.$ = window.jQuery = $;

require('./index_navigation');
