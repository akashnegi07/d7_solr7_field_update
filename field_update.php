<?php
#!/usr/bin/env drush
module_load_include('inc', 'field', 'field.crud');
// Fetch all apachesolr reference fields.
$result = db_select('field_config', 'f')
    ->fields('f')
    ->condition('type', 'apachesolr_reference')
    ->execute();
while($record = $result->fetchAssoc()) {
  $field_name = $record['field_name'];
  // Get field info.
  $field = field_info_field($field_name);
  // Update index server if the new one exists.
  $env = 'acquia_search_server_3';
  $solr_index_exist = apachesolr_environment_load($env);
  if ($solr_index_exist) {
    $field['settings']['solr_env'] = $env;
    field_update_field($field);
  }
}
