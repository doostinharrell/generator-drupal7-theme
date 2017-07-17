<?php

/*
 * Include partials.
 */
require_once dirname(__FILE__) . '/inc/form.inc';
require_once dirname(__FILE__) . '/inc/menu.inc';

/**
 * Implements hook_css_alter().
 */
function <%= themeMachineName %>_css_alter(&$css) {
  // Remove unnecessary styles provided by drupal core and contrib modules.
  unset($css['modules/system/system.menus.css']);
  unset($css['modules/system/system.messages.css']);
  unset($css['modules/system/system.theme.css']);
}

/*
 * Implements hook_preprocess_html().
 */
function <%= themeMachineName %>_preprocess_html(&$variables) {

}

/*
 * Implements hook_preprocess_page().
 */
function <%= themeMachineName %>_preprocess_page(&$variables) {
if (!empty($variables['main_menu'])) {
  $variables['main_menu'] = theme('build_menu', array('menu_tree' => 'main-menu'));
}
}

/**
 * Implements hook_preprocess_node().
 */
function <%= themeMachineName %>_preprocess_node(&$variables) {
  // Create generic view mode theme hook suggestions and make it this 1st item in the array.
  array_unshift($variables['theme_hook_suggestions'], 'node__' . $variables['view_mode']);
}

/**
 * Discover and invoke any preprocess hooks for entities based on their type
 * and bundle.
 */
function <%= themeMachineName %>_preprocess_entity(&$variables) {
  $entity_type = $variables['entity_type'];
  $function = '<%= themeMachineName %>_preprocess_' . $entity_type;

  if (function_exists($function)) {
    $function($variables);
  }

  if (isset($variables[$entity_type])) {
    $entity = $variables[$entity_type];
    list(, , $bundle) = entity_extract_ids($entity_type, $entity);

    $function = $function . '_' . $bundle;
    if (function_exists($function)) {
      $function($variables);
    }
  }
}

/**
 * Implements theme_breadcrumb().
 */
function <%= themeMachineName %>_breadcrumb($variables) {
  $breadcrumb = !empty($variables['breadcrumb']) ? $variables['breadcrumb'] : NULL;

  if (!empty($breadcrumb)) {
    // Add current page title as last item in breadcrumb.
    $title = drupal_get_title();
    if (!empty($title)) {
      $breadcrumb[] = $title;
    }

    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<nav aria-label="' . t('You are here') . ':" role="navigation">';
    $output .= '<ul class="breadcrumbs"><li>' . implode('</li><li>', $breadcrumb) . '</li></ul>';
    $output .= '</nav>';
    return $output;
  }
}

/*
 * Implements theme_pager_previous().
 */
function <%= themeMachineName %>_pager_previous($variables) {
  $text = $variables['text'];
  $element = $variables['element'];
  $interval = $variables['interval'];
  $parameters = $variables['parameters'];
  global $pager_page_array;
  $output = '';

  // If we are on the first page
  if ($pager_page_array[$element] == 0) {
    $output = t($text);
  }

  // If we are anywhere but the first page
  if ($pager_page_array[$element] > 0) {
    $page_new = pager_load_array($pager_page_array[$element] - $interval, $element, $pager_page_array);

    // If the previous page is the first page, mark the link as such.
    if ($page_new[$element] == 0) {
      $output = theme('pager_first', array('text' => $text, 'element' => $element, 'parameters' => $parameters));
    }
    // The previous page is not the first page.
    else {
      $output = theme('pager_link', array('text' => $text, 'page_new' => $page_new, 'element' => $element, 'parameters' => $parameters));
    }
  }

  return $output;
}

/**
 * Implements theme_pager_next().
 */
function <%= themeMachineName %>_pager_next($variables) {
  $text = $variables['text'];
  $element = $variables['element'];
  $interval = $variables['interval'];
  $parameters = $variables['parameters'];
  global $pager_page_array, $pager_total;
  $output = '';

  // If we are anywhere but the last page
  if ($pager_page_array[$element] < ($pager_total[$element] - 1)) {
    $page_new = pager_load_array($pager_page_array[$element] + $interval, $element, $pager_page_array);
    // If the next page is the last page, mark the link as such.
    if ($page_new[$element] == ($pager_total[$element] - 1)) {
      $output = theme('pager_last', array('text' => $text, 'element' => $element, 'parameters' => $parameters));
    }
    // The next page is not the last page.
    else {
      $output = theme('pager_link', array('text' => $text, 'page_new' => $page_new, 'element' => $element, 'parameters' => $parameters));
    }
  }
  // If we are on the last page
  else if ($pager_page_array[$element] == ($pager_total[$element] - 1)) {
    $output = t($text);
  }

  return $output;
}

/**
 * Implements theme_pager().
 */
function <%= themeMachineName %>_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  $pager_current = $pager_page_array[$element] + 1;
  $pager_first = $pager_current - $pager_middle + 1;
  $pager_last = $pager_current + $quantity - $pager_middle;
  $pager_max = $pager_total[$element];

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('Previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('Next')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($pager_current == 1 && $li_previous) {
      $items[] = array(
        'class' => array('pagination-previous', 'disabled'),
        'data' => $li_previous,
      );
    }
    elseif ($li_previous) {
      $items[] = array(
        'class' => array('pagination-previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('ellipsis'),
          'data' => '',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('current'),
            'data' => $i,
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
    }
    // End generation.
    if (($pager_current == $pager_total[$element]) && $li_previous) {
      $items[] = array(
        'class' => array('pagination-next', 'disabled'),
        'data' => $li_next,
      );
    }
    else if ($li_next) {
      $items[] = array(
        'class' => array('pagination-next'),
        'data' => $li_next,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pagination', 'text-center'), 'role' => array('navigation'), 'aria-label' => array('Pagination')),
    ));
  }
}

/**
 * Implements theme_status_messages().
 */
function <%= themeMachineName %>_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {
    $output .= '<div class="messages messages--' . $type . '">';
    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>";
    }
    if (count($messages) > 1) {
      $output .= '<ul>';
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . '</li>';
      }
      $output .= '</ul>';
    }
    else {
      $output .= $messages[0];
    }
    $output .= '</div>';
  }

  return $output;
}

/**
 * Implements theme_item_list().
 * Customized to remove div.item-list wrapper.
 */
function <%= themeMachineName %>_item_list($variables) {
  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];

  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.
  $output = '';
  if (isset($title) && $title !== '') {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
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
    $output .= "</$type>";
  }
  return $output;
}

/**
 * Implements hook_theme().
 */
function <%= themeMachineName %>_theme($existing, $type, $theme, $path) {
  return array(
    'build_menu' => array(
      // $menu_tree string representing the menu tree to build
      // $menu_classes array of classes to add to the menu
      // $data_options string of data options as per http://foundation.zurb.com/sites/docs/menu.html
      'variables' => array(
        'menu_tree' => 'main-menu',
        'menu_classes' => array('menu', 'dropdown'),
        'data_options' => 'data-dropdown-menu',
      ),
    ),
    'prepare_menu_items' => array(
      'variables' => array(),
    ),
  );
}
