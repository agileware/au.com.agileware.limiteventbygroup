# Limit Event By Group (au.com.agileware.limiteventbygroup)

This is a [CiviCRM](https://civicrm.org) extension which restricts CiviCRM Event registration to
members of a specified Contact Group. It solves the problem of needing to make an Event visible and
listed publicly, while still only allowing a defined set of people (e.g. members, staff, or a
specific committee) to actually complete registration for it.

If no group is configured for an Event, registration remains open to everyone as normal — the
extension is opt-in on a per-Event basis.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements Implemented

This extension fulfills the following core requirements:

Custom Field Creation: Creates a Custom Group (Limit_Event) attached to the Event entity, containing an Entity Reference field (limit_event_group_ref) that links to Contact Groups.

Restriction Check: The hook checks the value of this custom field during the registration process.

Membership Enforcement: Only users who are logged in and whose Contact ID is found as a member (Added or Pending) of the selected Contact Group are allowed to proceed to registration.

Public Access: If the custom group field is left empty, no restriction is applied, and anyone can register.

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
    | 2. Enforce Login | Ensure the participant is a known, logged-in user before applying group restrictions. | Checks both `$form->getContactID()` and `CRM_Core_Session::getLoggedInContactID()`. If either is missing, registration is blocked with an "Event Registration Restricted" error. |
    | 3. Check Membership | Determine whether the identified participant belongs to the required group. | Uses `\Civi\Api4\GroupContact::get()` with conditions on `group_id` and `contact_id`. The query returns a count (`1` if matched). |
    | 4. Block Access | Deny access if the user is not a valid group member. | If `$isMember` is **FALSE**, registration is blocked with an "Event Registration Restricted" error. |

    The check runs on `CRM_Event_Form_Registration_Confirm` (the final confirmation step of the
    registration flow), so a restricted Event's registration form itself is still publicly viewable —
    only submission of the registration is blocked for non-members.

## Special Configuration Requirements

This extension requires no special configuration, credentials, or settings pages to function. On
install it registers the `Limit_Event` Custom Group and its `Limit_Event_Group` field automatically
via a managed entity, ready to use on any Event as described in the Usage Guide above.

The only per-Event setup required is selecting the Contact Group in the Event's Custom Data tab, as
described above. Note that participants must be logged in and identifiable as CiviCRM Contacts for
the group membership check to succeed — anonymous registration will always be blocked on a
restricted Event.

## Requirements

* CiviCRM 6.8+

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin
Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

# About the Authors

This CiviCRM extension was developed by the team at
[Agileware](https://agileware.com.au).

[Agileware](https://agileware.com.au) provide a range of CiviCRM
services including:

* CiviCRM migration
* CiviCRM integration
* CiviCRM extension development
* CiviCRM support
* CiviCRM hosting
* CiviCRM remote training services

Support your Australian [CiviCRM](https://civicrm.org) developers,
[contact Agileware](https://agileware.com.au/contact) today!

![Agileware](logo/agileware-logo.png)
