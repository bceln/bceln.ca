<?php

/**
 * @file
 * Default theme implementation to present all user profile data.
 *
 * This template is used when viewing a registered member's profile page,
 * e.g., example.com/user/123. 123 being the users ID.
 *
 * Use render($user_profile) to print all profile items, or print a subset
 * such as render($user_profile['user_picture']). Always call
 * render($user_profile) at the end in order to print all remaining items. If
 * the item is a category, it will contain all its profile items. By default,
 * $user_profile['summary'] is provided, which contains data on the user's
 * history. Other data can be included by modules. $user_profile['user_picture']
 * is available for showing the account picture.
 *
 * Available variables:
 *   - $user_profile: An array of profile items. Use render() to print them.
 *   - Field variables: for each field instance attached to the user a
 *     corresponding variable is defined; e.g., $account->field_example has a
 *     variable $field_example defined. When needing to access a field's raw
 *     values, developers/themers are strongly encouraged to use these
 *     variables. Otherwise they will have to explicitly specify the desired
 *     field language, e.g. $account->field_example['en'], thus overriding any
 *     language negotiation rule that was previously applied.
 *
 * @see user-profile-category.tpl.php
 *   Where the html is handled for the group.
 * @see user-profile-item.tpl.php
 *   Where the html is handled for each item in the group.
 * @see template_preprocess_user_profile()
 *
 * @ingroup themeable
 */
?>
<div class="profile"<?php print $attributes; ?>>
  <?php //dpm(get_defined_vars()); ?>
  <?php hide($user_profile['profile_contact']); ?>
  <?php $contact = $user_profile['profile_contact']['view']['profile2']; ?>
  <?php foreach ($contact as $contact_item): ?>
  <?php
    $organization = $contact_item['field_organization_ref']['#items'][0]['node'];
    $location = $organization->field_location['und'][0];
    hide($contact_item['field_contact_photo']);
    hide($contact_item['field_contact_first_name']);
    hide($contact_item['field_contact_last_name']);
    dpm($location);
  ?>
  <div class="row-container">
    <div class="row">
      <div class="columns one">
        <?php
          $contact_item['field_contact_photo']['#label_display'] = TRUE;
          print render($contact_item['field_contact_photo']);
        ?>
      </div>
      <div class="columns eleven">
        <div class="field-label"><?php print t('Name'); ?>:</div>
        <div class="field-item field field-name-field-contact-last-name field-type-text field-label-above even">
          <?php print $contact_item['field_contact_first_name']['#items'][0]['safe_value']; ?>
          <?php print $contact_item['field_contact_last_name']['#items'][0]['safe_value']; ?>
        </div>
        <?php print render($contact_item); ?>
        <?php
          // Manually render location field here--because Drupal sucks?
          //
          // It should be possible, using the node, $organization, to 
          // either render the field_location field directly, or at 
          // least to pass the node object through 
          // node_prepare_content() and then render the field. None of 
          // this works in this context for some reason. Consequently, 
          // we do it manually: 
        ?>
        <div class="field-label"><?php print t('Address'); ?>:</div>
        <div class="location vcard">
          <div class="adr">
            <span class="fn"></span> 
            <div class="street-address"><?php print $location['street']; ?></div> 
            <span class="locality"><?php print $location['city']; ?> <?php print $location['province'] ?></span> 
            <span class="postal-code"><?php print $location['postal_code']; ?></span>
            <div class="country-name"><?php print $location['country_name']; ?></div>
          </div> <!-- // close adr -->
        </div>
      </div>
    </div>
  </div>
  <?php endforeach;?>
  <?php print render($user_profile); ?>
</div>

