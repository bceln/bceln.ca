Updating the node ref fieldd in Resources content type. Because there are GUID's that are same in licenses and vendors the drupal site didn't like it. This fixed it.

Found it here - https://drupal.org/comment/6625798#comment-6625798

## License Field
UPDATE field_data_field_resources_license l
INNER JOIN feeds_item fi ON l.field_resources_license_nid=fi.entity_id
INNER JOIN (SELECT * FROM feeds_item WHERE id="node") statuses ON fi.guid = statuses.guid
AND fi.id <> 'node'
SET l.field_resources_license_nid = statuses.entity_id;

## Vendors Field
UPDATE field_data_field_resource_vendor_ref v
INNER JOIN feeds_item fi ON v.field_resource_vendor_ref_nid=fi.entity_id
INNER JOIN (SELECT * FROM feeds_item WHERE id="vendors_import") statuses ON fi.guid = statuses.guid
AND fi.id <> 'vendors_import'
SET v.field_resource_vendor_ref_nid = statuses.entity_id;