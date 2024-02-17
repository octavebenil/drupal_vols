function deleteEntity(entity_id) {
  if (confirm('Etes vous vraiment sûr de supprimer cet élément ?')) {
    jQuery("#delete_form-"+entity_id).submit();
  }
}
