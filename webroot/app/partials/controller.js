app.controller('LeftController', function($scope, Auth) { 
  Auth.query(function(res) {
    $scope.member = {}

    if (res.ok) {
      $scope.member = res.data
    } else {
      window.location = appUrl('login')
    }
  })
})
