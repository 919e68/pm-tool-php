app.factory('Profile', function($resource) {
  return $resource( api + 'profile/', {}, {
    query: { method: 'GET', isArray: false },
  })
})