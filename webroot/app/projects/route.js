app.config(function($stateProvider) { 
  $stateProvider
    .state('projects', {
      url: appUrl('projects'),
      views: {
        '': {
          templateUrl: templateUrl('projects/_index.html'),
          controller: 'ProjectController'
        },
        'left@projects': { 
          templateUrl: templateUrl('partials/_left.html'),
          controller: 'LeftController'
        }
      }
    })
})