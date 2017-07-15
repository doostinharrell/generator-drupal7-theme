import $ from 'jquery';
import whatInput from 'what-input';

window.$ = $;

import Foundation from 'foundation-sites';
// If you want to pick and choose which modules to include, comment out the above and uncomment
// the line below
//import './lib/foundation-explicit-pieces';

// Import custom javascript files.
import platform from './lib/platform';

// Initialize foundation.
$(document).foundation();

// START - Add Browser classes.
$(document).ready(function() {
  // Add IE Classes
  if ((platform.version == '11.0') && (platform.name == 'IE') && (platform.os.version == '8.1') && (platform.os.family == 'Windows')) {
    $('body').addClass('win8-ie11');
  }
  if (platform.name == 'IE') {
    $('body').addClass('win-ie');
  }
  // Add Edge Classes
  if (platform.name == 'Microsoft Edge') {
    $('body').addClass('win-edge');
  }
  // Add Safari Classes
  if ((platform.name == 'Safari') && (platform.os.family == 'OS X')) {
    $('body').addClass('osx-safari');
  }
});
// END - Add Browser classes.
