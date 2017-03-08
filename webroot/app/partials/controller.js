app.controller('LeftController', function($scope, Profile) { 
  Profile.query(function(res) {
    $scope.member = {}

    if (res.ok) {
      $scope.member = res.data
    }
  })
})
