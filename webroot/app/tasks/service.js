app.factory("Task", function($resource) {
  return $resource( api + 'tasks/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
  
});
