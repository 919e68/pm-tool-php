app.controller('MemberController', function($scope, $routeParams, Member){
  
  // list members
  Member.query(function(e){
    $scope.members = e.result;
  });
  
});

app.controller('MemberMessageController', function($scope, $timeout, $routeParams, Message, MemberId){
  
  $scope.ws = new WebSocket(wsUrl);
  $scope.ws.onmessage = function(e){
    res = JSON.parse(e.data);
    if(res.app=='pm-tool' && res.component=='messages'){
      if(res.data.from==memberdata.id || res.data.to==memberdata.id){
        $timeout(function(){ $scope.messages.unshift(res.data);}, 100);
      }
    }
  }

  // list message
  MemberId.get({user:$routeParams.user}, function(e){
    $scope.memberId = e.result;
    Message.get({id:$scope.memberId}, function(f){
      $scope.messages = f.result;
    });
    $scope.newmessage = {Message:{from:memberdata.id, to:$scope.memberId, message:''}};
  });
  
  // new message
  $('#message-area').keypress(function(event) {
    if (event.keyCode == 13 && !event.shiftKey) {
      $scope.sendMessage();
      return false;
     }
  });
  
  $scope.sendMessage = function(){
    if($scope.newmessage.Message.message != ''){
      Message.save($scope.newmessage, function(e){
        $scope.newmessage.Message.message = '';
        if(e.response){
          message = {
            app: 'pm-tool',
            component: 'messages',
            data: e.data
          }
          message = JSON.stringify(message);
          $scope.ws.send(message);
        }
      });
    }
  }
  // .new message
  
});

app.controller('MemberProfileController', function($scope, $routeParams){

});