app.config(function($routeProvider, $locationProvider) {
  $routeProvider
  .when('/members', {
    templateUrl: base + '/app/members/_index.html',
    controller: 'MemberController',
  })
  .when('/messages/:user', {
    templateUrl: base + '/app/members/_chat.html',
    controller: 'MemberMessageController',
  })
  .when('/profile', {
    templateUrl: base + '/app/members/_profile.html',
    controller: 'MemberProfileController',
  });
});