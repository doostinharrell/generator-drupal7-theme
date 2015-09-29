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
    'admin css' => 'panel.css',
    'regions' => array(
      'header' => t('Header'),
      'column_1' => t('Column 1'),
      'column_2' => t('Column 2'),
    ),
  );
  return $items;
}
