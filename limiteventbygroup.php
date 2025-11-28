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
  // This calls the code in install/limiteventbygroup_install.php
  _limiteventbygroup_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function limiteventbygroup_civicrm_uninstall(): void {
  // This calls the code in install/limiteventbygroup_install.php
  _limiteventbygroup_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function limiteventbygroup_civicrm_enable(): void {
  _limiteventbygroup_civix_civicrm_enable();
}
// Other hooks go here