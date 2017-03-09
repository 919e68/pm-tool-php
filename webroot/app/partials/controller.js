app.controller('LeftController', function($scope, Auth) {
  $scope.logoutUrl = appUrl('logout')

  Auth.query(function(res) {
    $scope.member = {}
    $onlineMembers = []

    if (res.ok) {
      $scope.member = res.data.profile
      $scope.onlineMembers = res.data.online_members
    } else {
      window.location = appUrl('login')
    }
  })
})
