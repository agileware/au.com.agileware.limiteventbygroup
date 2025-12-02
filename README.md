# Limit Events by Group (au.com.agileware.limiteventbygroup)

The "Limit Events by Group" extension provides a mechanism to restrict access to event registration forms. It enforces that only active members of a specified CiviCRM Contact Group are allowed to complete registration for a particular event. If no group is specified for an event, registration remains open to the public.

## Requirements Implemented

This extension fulfills the following core requirements:

Custom Field Creation: Creates a Custom Group (Limit_Event) attached to the Event entity, containing an Entity Reference field (limit_event_group_ref) that links to Contact Groups.

Restriction Check: The hook checks the value of this custom field during the registration process.

Membership Enforcement: Only users who are logged in and whose Contact ID is found as a member (Added or Pending) of the selected Contact Group are allowed to proceed to registration.

Public Access: If the custom group field is left empty, no restriction is applied, and anyone can register.

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin
Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Usage Guide

1. Configure the Custom Field

    After installation, the restriction field will be available on all events:

    Navigate to an Event (e.g., Events » Manage Events).

    Go to the Configure tab for that event.

    Click Custom Data.

    You will see the Limit Event Custom Group, which contains the field: Required Contact Group for Registration.

    Select the Contact Group whose members should be the only people allowed to register.

    Click Save.

2. Logic summary

    | Step | Action | Logic |
    |------|--------|--------|
    | 1. Public Bypass | Fetch the event’s required Group ID from the custom field. Allow registration if no group restriction is configured. | If `empty($customFieldGroupId)` is **TRUE**, the function returns immediately — anyone may register. |
    | 2. Enforce Login | Ensure the participant is a known, logged-in user before applying group restrictions. | Checks both `$form->getContactID()` and `CRM_Core_Session::getLoggedInContactID()`. If either is missing, an error message is set and the user is redirected to the Event Info page. |
    | 3. Check Membership | Determine whether the identified participant belongs to the required group. | Uses `\Civi\Api4\GroupContact::get()` with conditions on `group_id`, `contact_id.` `The query returns a count (`1` if matched). |
    | 4. Block Access | Deny access if the user is not a valid group member. | If `$isMember` is **FALSE**, sets an error status and redirects the user back to the Event Info page. |
