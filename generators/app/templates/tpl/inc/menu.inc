<?php

/**
 * Implements theme_menu_local_tasks().
 */
function <%= themeMachineName %>_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="menu">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="menu">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

/**
 * Implements theme_menu_local_task().
 */
function <%= themeMachineName %>_menu_local_task(&$variables) {
  $link = $variables['element']['#link'];
  $link_text = $link['title'];
  $link_class = !empty($variables['element']['#active']) ? 'primary' : 'secondary';
  $li_class = !empty($variables['element']['#active']) ? ' class="active"' : '';

  if (!empty($variables['element']['#active'])) {
    // Add text to indicate active tab for non-visual users.
    $active = '<span class="element-invisible">' . t('(active tab)') . '</span>';

    // If the link does not contain HTML already, check_plain() it now.
    // After we set 'html'=TRUE the link will not be sanitized by l().
    if (empty($link['localized_options']['html'])) {
      $link['title'] = check_plain($link['title']);
    }
    $link['localized_options']['html'] = TRUE;
    $link_text = t('!local-task-title!active', array('!local-task-title' => $link['title'], '!active' => $active));
  }

  // Add section tab styling
  $link['localized_options']['attributes']['class'] = array($link_class, 'small', 'button');

  $output = '<li' . $li_class . '>';
  $output .= l($link_text, $link['href'], $link['localized_options']);
  $output .= "</li>\n";
  return  $output;
}

/**
 * Implements theme_menu_tree().
 */
function <%= themeMachineName %>_menu_tree(&$variables) {
  // Convert menu block sto Foundation vertical menu.
  return '<ul class="vertical menu">' . $variables['tree'] . '</ul>
';
}

/**
 * Implements theme_menu_tree__main_menu().
 */
function <%= themeMachineName %>_menu_tree__main_menu(&$variables) {
  // Convert main menu block to Foundation dropdown menu.
  return '<ul class="dropdown menu" data-dropdown-menu>' . $variables['tree'] . '</ul>
';
}

/**
 * Theme function for building menus.
 *
 * @params
 *  $variables['menu_tree'] string representing the menu tree to build
 *  $variables['menu_classes'] array of classes to add to the menu
 *  $variables['data_options'] string of data options as per http://foundation.zurb.com/sites/docs/menu.html
 *
 * @return
 *  Returns a render array of the passed menu
 */
function <%= themeMachineName %>_build_menu($variables) {
  $items = menu_tree($variables['menu_tree']);
  $menu_links = array(
    'items' => array(),
    'title' => '',
    'attributes' => array(),
  );

  foreach ($items as $key => $item) {
    if (is_numeric($key)) {
      $active_state = NULL;
      if (in_array('active-trail', $item['#attributes']['class'])) {
        $active_state = 'active';
      }
      // Create sub-menu.
      foreach ($item['#below'] as $key => $value) {
        if (is_numeric($key)) {
          $sub_menu_links = array(
            'items' => array(),
            'title' => '',
            'type' => 'ul',
            'attributes' => array('class' => array('menu', 'vertical')),
          );
          foreach ($item['#below'] as $key => $subitem) {
            if (is_numeric($key)) {
              $sub_menu_links['items'][] =  l($subitem['#title'], $subitem['#href']);
            }
          }
        }
      }

      // Build main menu.
      if (!empty($sub_menu_links)) {
        // Add class to li if sub-menu exists else.
        $menu_links['items'][] = array(
          'data' => l($item['#title'], $item['#href']) . theme('item_list', $sub_menu_links),
          'class' => array($active_state),
        );
      }
      else {
        $menu_links['items'][] = array(
          'data' => l($item['#title'], $item['#href']),
        );
      }

      // Reset sub-menu.
      unset($sub_menu_links);
    }
  }

  return theme('prepare_menu_items', $menu_links);
}

/**
 * Custom theme function to theme main menu links.
 */
function <%= themeMachineName %>_prepare_menu_items($variables) {
  $items = $variables['items'];
  $title = $variables['title'];

  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.
  $output = '';

  if (!empty($items)) {
    $num_items = count($items);
    $i = 0;
    foreach ($items as $item) {
      $attributes = array();
      $children = array();
      $data = '';
      $i++;
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        // Render nested list.
        $data .= theme_item_list(array('items' => $children, 'title' => NULL, 'type' => $type, 'attributes' => $attributes));
      }
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
    }
  }
  return $output;
}
