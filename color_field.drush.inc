<?php

/**
 * @file
 * Drush integration for color fields plugin.
 */

/**
 * The Field Timetable plugin URI.
 */
define('COLOR_FIELD_JQUERY_SIMPLE_COLOR_DOWNLOAD_URI', 'http://recursive-design.com/projects/jquery-simple-color/jquery-simple-color.1.0.1.zip');

/**
 * Implements hook_drush_command().
 */
function color_field_drush_command() {
  $items = array();

  // The key in the $items array is the name of the command.
  $items['color_fied-plugin-jsc'] = array(
    'description' => dt("Downloads the jQuery Simple Color plugin."),
    'arguments' => array(
      'path' => dt('Optional. A path where to install the jQuery Simple Color plugin. If omitted Drush will use the default location.'),
    ),
  );

  return $items;
}

/**
 * Implements hook_drush_help().
 */
function color_field_drush_help($section) {
  switch ($section) {
    case 'drush:color_fied-plugin-jsc':
      return dt("Downloads the jQuery Simple Color plugin, default location is sites/all/libraries.");
  }
}

/**
 * Commands to download the Field Timetable plugin.
 */
function drush_color_field_color_fied_plugin_jsc($path = 'sites/all/libraries') {
  if (!drush_shell_exec('type unzip')) {
    return drush_set_error(dt('Missing dependency: unzip. Install it before using this command.'));
  }

  // Create the path if it does not exist.
  if (!is_dir($path)) {
    drush_op('mkdir', $path);
    drush_log(dt('Directory @path was created', array('@path' => $path)), 'notice');
  }

  // Set the directory to the download location.
  $olddir = getcwd();
  chdir($path);

  $filename = 'jquery-simple-color.1.0.1.zip';

  $dirname = 'jquery-simple-color';

  // Remove any existing jQuery Simple Color plugin directory.
  if (is_dir($dirname)) {
    drush_log(dt('A existing jQuery Simple Color plugin was overwritten at @path', array('@path' => $path)), 'notice');
  }
  // Remove any existing jQuery Simple Color plugin zip archive.
  if (is_file($filename)) {
    drush_op('unlink', $filename);
  }

  // Download the zip archive.
  if (!drush_shell_exec('wget ' . COLOR_FIELD_JQUERY_SIMPLE_COLOR_DOWNLOAD_URI)) {
    drush_shell_exec('curl -kOL ' . COLOR_FIELD_JQUERY_SIMPLE_COLOR_DOWNLOAD_URI);
  }

  if (is_file($filename)) {
    // Decompress the zip archive.
    drush_shell_exec('unzip -qq -o ' . $filename);
    // Remove old librairy.
    if (is_dir('jquery-simple-color')) {
    }
    // Remove the zip archive.
    drush_op('unlink', $filename);

  }

  // Set working directory back to the previous working directory.
  chdir($olddir);

  if (is_dir($path . '/jquery-simple-color')) {
    drush_log(dt('jQuery Simple Color  plugin has been downloaded to @path', array('@path' => $path)), 'success');
  }
  else {
    drush_log(dt('Drush was unable to download the jQuery Simple Color  plugin to @path', array('@path' => $path)), 'error');
  }
}
