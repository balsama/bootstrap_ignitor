<?php

/**
 * @file
 * template.php. Preprocess hooks and helper functions to alter the output of
 * renderable arrays.
 */

/**
 * Implements hook_preprocess_page().
 *
 * @see page.tpl.php
 */
function bootstrap_ignitor_preprocess_page(&$variables) {
  // Warn users that they are viewing a BEAN page. BEANs are not typically
  // viewed as a page - only as blocks or as part of a larger node. As such,
  // their formatting might look a little "off" when viewing them as
  // stand-alone entities.
  if (arg(0) == 'block') {
    if (is_array($variables['page']['content']['system_main']['bean'])) {
      $bean = reset($variables['page']['content']['system_main']['bean']);
      drupal_set_message(t('You are viewing a single <em>' . $bean['#bundle'] . '</em> block. These blocks are generally not viewed directly by End Users and their formatting may appear different on this page.'), 'info');
    }
  }
}

/**
 * Overrides bootstrap_bootstrap_search_form_wrapper().
 *
 * Outputs an icon for the search form instead of text even though we're not
 * loading bootstrap from a CDN. (The deault function assumes we don't have the
 * bootstrap icons if we don't load the library from the CDN.)
 */
function bootstrap_ignitor_bootstrap_search_form_wrapper($variables) {
  $output = '<div class="input-group">';
  $output .= $variables['element']['#children'];
  $output .= '<span class="input-group-btn">';
  $output .= '<button type="submit" class="btn btn-default">';
  $output .= _bootstrap_icon('search');
  $output .= '</button>';
  $output .= '</span>';
  $output .= '</div>';
  return $output;
}

/**
 * Overrides bootstrap_menu_link().
 *
 * Resets theme_menu_link() to the default that ships with Drupal. Bootstrap
 * attempts to make every menu with children into a dropdown menu. Remove this
 * function if you want drop down links.
 */
function bootstrap_ignitor_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Implements hook_form_alter().
 *
 * Adds the button class to all form submit buttons.
 */
function bootstrap_ignitor_form_alter(&$form, &$form_state, $form_id) {
  $form['actions']['submit']['#attributes']['class'][] = 'btn';
}

