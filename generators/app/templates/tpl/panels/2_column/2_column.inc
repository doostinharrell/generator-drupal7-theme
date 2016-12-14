<?php

/**
 * Implements hook_panels_layouts()
 */
function <%= themeMachineName %>_2_column_panels_layouts() {
  $items['2_column'] = array(
    'title' => t('2 Column Layout'),
    'category' => t('<%= themeHumanName %>'),
    'icon' => 'panel.png',
    'theme' => '2_column',
    'admin css' => '../panels-styles.css',
    'regions' => array(
      'header' => t('Header'),
      'column_1' => t('Column 1'),
      'column_2' => t('Column 2'),
    ),
  );
  return $items;
}

/**
 * Implements template_preprocess_HOOK().
 */
function <%= themeMachineName %>_preprocess_2_column(&$variables, $hook) {
  // do stuff
}
