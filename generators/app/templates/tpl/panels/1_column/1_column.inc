<?php

/**
 * Implements hook_panels_layouts()
 */
function <%= themeMachineName %>_1_column_panels_layouts() {
  $items['1_column'] = array(
    'title' => t('1 Column Layout'),
    'category' => t('<%= themeHumanName %>'),
    'icon' => 'panel.png',
    'theme' => '1_column',
    'admin css' => '../panels-styles.css',
    'regions' => array(
      'header' => t('Header'),
      'column' => t('Column'),
    ),
  );
  return $items;
}

/**
 * Implements template_preprocess_HOOK().
 */
function <%= themeMachineName %>_preprocess_1_column(&$variables, $hook) {
  // do stuff
}
