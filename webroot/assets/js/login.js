var app = angular.module('login', ['ngResource']);

app.factory('Signin', function($resource) {
  return $resource( api + 'signin/:id', {id:'@id'}, {
    login: { method: 'POST' }
  });
});

app.controller('SigninController', function($scope, Signin) {
  $scope.user = { username: null, password: null };
  $scope.formErrors = [];

  $scope.signIn = function() {
    if ($scope.loginForm.$valid) {
      Signin.login($scope.user, function(res) {
        if (res.ok) {
          window.location = base;
        } else {
          $scope.formErrors = res.errors;
        }
      });
    }
  }
});