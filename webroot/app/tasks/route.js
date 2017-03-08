app.config(function($routeProvider, $locationProvider) {
  $routeProvider
  .when('/tasks', {
    templateUrl: base + '/app/tasks/_index.html',
    controller: 'TaskController',
  });
});