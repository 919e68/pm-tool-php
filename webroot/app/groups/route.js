app.config(function($routeProvider, $locationProvider) {
  $routeProvider
  .when('/groups', {
    templateUrl: base + '/app/groups/_index.html',
    controller: 'GroupController',
  })
  .when('/groups/:id', {
    templateUrl: base + '/app/groups/_view.html',
    controller: 'GroupViewController',
  });
});