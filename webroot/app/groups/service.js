app.factory("Group", function($resource) {
  return $resource( api + 'groups/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});

app.factory("GroupMenu", function($resource) {
  return $resource( api + 'select/groupmenu', {}, {
    query: { method: 'GET', isArray: false }
  });
});
