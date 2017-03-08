var app = angular.module('pm-tool', ['ngResource', 'ngRoute', 'ngSanitize']);

app.config(function($routeProvider) {
  $routeProvider
  .otherwise({
    redirectTo: '/dashboard'
  });
});






