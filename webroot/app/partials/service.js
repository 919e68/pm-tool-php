app.factory('Auth', function($resource) {
  return $resource( appUrl('auth'), {}, {
    query: { method: 'GET', isArray: false },
  })
})
