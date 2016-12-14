<?php

/**
 * Implements hook_form_alter().
 */
function <%= themeMachineName %>_form_alter(&$form, &$form_state, $form_id) {
  // Id's of forms that should be ignored
  $form_ids = array(
    'node_form',
    'system_site_information_settings',
    'user_profile_form',
    'node_delete_confirm',
    'views_ui_edit_form',
  );

  // Allow other modules to alter this.
  drupal_alter('<%= themeMachineName %>_ignored_forms', $form_ids);

  // Only wrap in container for certain form
  if (isset($form['#form_id']) && !in_array($form['#form_id'], $form_ids) && !isset($form['#node_edit_form'])) {
    $form['actions']['#theme_wrappers'] = array();
  }

  // Sexy submit buttons
  if (!empty($form['actions']) && !empty($form['actions']['submit'])) {
    $form['actions']['submit']['#attributes']['class'][] = 'secondary';
    $form['actions']['submit']['#attributes']['class'][] = 'button';
    $form['actions']['submit']['#attributes']['class'][] = 'radius';
  }
  if (!empty($form['basic']) && !empty($form['basic']['submit'])) {
    $form['basic']['submit']['#attributes']['class'][] = 'secondary';
    $form['basic']['submit']['#attributes']['class'][] = 'button';
    $form['basic']['submit']['#attributes']['class'][] = 'radius';
  }

  // Add tooltips to form elements.
  if (theme_get_setting('<%= themeMachineName %>_tooltip_enable')
    && theme_get_setting('<%= themeMachineName %>_tooltip_mode') === 'element') {
    // Get tooltip settings.
    $position = theme_get_setting('<%= themeMachineName %>_tooltip_position');
    $touch = theme_get_setting('<%= themeMachineName %>_tooltip_touch');

    foreach (element_children($form) as $item) {
      foreach (element_children($form[$item]) as $i) {
        $element =& $form[$item][$i];

        if (!empty($element['#description'])) {
          $element['#attributes']['data-tooltip'] = NULL;
          $element['#attributes']['class'][] = 'has-tip';
          $element['#attributes']['class'][] = $position;
          $element['#attributes']['title'] = $element['#description'];

          if ($touch) {
            $element['#attributes']['data-options'] = 'disable-for-touch:true';
          }
        }
      }
    }
  }
}
