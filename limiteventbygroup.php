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

/**a
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function limiteventbygroup_civicrm_enable(): void {
  _limiteventbygroup_civix_civicrm_enable();
}

/*
 * Implements hook_civicrm_buildForm();
 
 * Deny registering for an event before the template is built.
 */

function limiteventbygroup_civicrm_buildForm($formName, &$form) {
  if ($formName === 'CRM_Event_Form_Registration_Confirm') {
    $eventId = $form->_eventId;
    $participantContactId = $form->getContactID();
  
    $events = \Civi\Api4\Event::get(FALSE)
    ->addSelect('Limit_Event.Limit_Event_Group')
    ->addWhere('id', '=', $eventId)
    ->setLimit(1)
    ->execute()->first();

    // The group ID is a simple array value from the APIv4 result.
    // If the field is empty, $customFieldGroupId will be NULL.
    $customFieldGroupId = $events['Limit_Event.Limit_Event_Group'] ?? NULL;

    // Check for 'no group set' (anyone can register)
    if (empty($customFieldGroupId)) {
      // Allow registration
      return; 
    }

    // If a group is required, the user must be logged in/identifiable.
    // Use the session ID here to check if *any* user is logged in to manage redirects.
    if (!$participantContactId || !CRM_Core_Session::getLoggedInContactID()) {
      CRM_Utils_System::setTitle(ts('Event Registration Restricted'));
      throw new CRM_Core_Exception(ts('Event registration is restricted. You must be logged in to register for this event.'));
    }

    // Check if the participant is in the required group using APIv4 (Recommended)
    try {
      $isMember = (bool) \Civi\Api4\GroupContact::get(FALSE)
        ->addWhere('group_id', '=', $customFieldGroupId)
        ->addWhere('contact_id', '=', $participantContactId)
        ->setLimit(1)
        ->execute()->count(); // Returns 1 if found, 0 otherwise
    } catch (\CRM_Core_Exception $e) {
      Civi::log()->error('GroupContact get failed. Error: ' . $e->getMessage());
      // Allow registration
      return;
    }

    // Block access if not a member.
    if (!$isMember) {

      CRM_Utils_System::setTitle(ts('Event Registration Restricted'));
      throw new CRM_Core_Exception(ts('Event registration is restricted. You must be a member of the required group to register for this event.'));
    }
  }
}
