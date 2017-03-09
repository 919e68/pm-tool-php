var app = angular.module('pm-tool', ['ngResource', 'ui.router'])

app.config(function($urlRouterProvider, $locationProvider) {

  $urlRouterProvider.otherwise(base)
  $locationProvider.html5Mode(true)

})

function appUrl(str) {
  return base + str
}

function apiUrl(str) {
  return api + str
}

function templateUrl(str) {
  return base + 'app/' + str
}






