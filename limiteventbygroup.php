<?php
declare(strict_types = 1);

// phpcs:disable PSR1.Files.SideEffects
require_once 'limiteventbygroup.civix.php';
// phpcs:enable

use CRM_Limiteventbygroup_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function limiteventbygroup_civicrm_config(\CRM_Core_Config $config): void {
  _limiteventbygroup_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function limiteventbygroup_civicrm_install(): void {
  _limiteventbygroup_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function limiteventbygroup_civicrm_enable(): void {
  _limiteventbygroup_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_managed().
 *
 * @param array $entities
 */
function limiteventbygroup_civicrm_managed(&$entities) {
  $fullKey = 'au.com.agileware.limiteventbygroup'; 

  $entities[] = [
    // Outer Array (to satisfy strict parsing)
    'module' => $fullKey,
    'name' => 'CustomGroupAndField',
    'entity' => 'File',
    'filename' => 'managed/CustomGroupAndField.php',

    // Inner Params Array (the actual definition)
    'params' => [
      'module' => $fullKey,
      'name' => 'CustomGroupAndField',
      'entity' => 'File',
      'filename' => 'managed/CustomGroupAndField.php',
    ],
  ];
}