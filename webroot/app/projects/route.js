app.config(function($routeProvider, $locationProvider) {
  $routeProvider
  .when('/projects', {
    templateUrl: base + '/app/projects/_index.html',
    controller: 'ProjectController',
  })
  .when('/projects/:slug', {
    templateUrl: base + '/app/projects/_view.html',
    controller: 'ProjectViewController',
  });
});