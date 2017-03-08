app.factory("Project", function($resource) {
  return $resource( api + 'projects/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});

app.factory("ProjectMember", function($resource) {
  return $resource( api + 'project-members/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});


app.factory("ProjectMessage", function($resource) {
  return $resource( api + 'project-messages/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});


app.factory("ProjectMenu", function($resource) {
  return $resource( api + 'select/projectmenu', {}, {
    query: { method: 'GET', isArray: false }
  });
});

app.factory("ProjectId", function($resource) {
  return $resource( api + 'select/projectid/:slug', {slug:'@slug'}, {
    query: { method: 'GET', isArray: false }
  });
});