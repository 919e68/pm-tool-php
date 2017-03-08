app.controller('MenuController', function($scope, $timeout, $routeParams, ProjectMenu, OnlineUser, Project, GroupMenu){

	$scope.ws = new WebSocket(wsUrl);
  $scope.ws.onmessage = function(e){
    res = JSON.parse(e.data);
    console.log(res);
    if(res.app == 'pm-tool' && res.component == 'project-menu'){
      $timeout(function(){ $scope.loadProjectMenu(); }, 100);
    }else if(res.app == 'pm-tool' && res.component == 'project-messages'){
      if(res.data.memberId == memberdata.id){
        popsound();
        notify({ title: 'PROJECT MESSAGE', body: res.data.message });
      }
    }else if(res.app == 'pm-tool' && res.component == 'project-members'){
      if(res.data.memberId == memberdata.id){
        popsound();
        if(res.data.type == 'add'){
          notify({title: 'ADDED INTO PROJECT', body: "(" + res.data.projectName + ")\n" + 'You are now member of the project.' });
        }else if(res.data.type == 'delete'){
          notify({title: 'REMOVED FROM PROJECT', body: "(" + res.data.projectName + ")\n" + 'You had been removed on the project.' });
        }
        $timeout(function(){$scope.loadProjectMenu();},10);
      }
    }else if(res.app == 'pm-tool' && res.component == 'messages'){
			if(memberdata.id == res.data.to){
				popsound();
				notify({title: 'NEW MESSAGE', body: "(" + res.data.name + ")\n" + res.data.message });
			}
		}
  };
	
	$scope.ws.onclose = function(e){
		alert();
	}
  
  // projects list
  $scope.loadProjectMenu = function(){
    ProjectMenu.query(function(e){
      $scope.memberRole = e.role;
      $scope.projects = e.result;
    });
  }
   $scope.loadProjectMenu();

  
  // members list
  $scope.loadOnlineUser = function(){
    OnlineUser.query(function(e){
      $scope.members = e.result;
    });
  }
  $scope.loadOnlineUser();

  
  // group list
  $scope.loadGroup = function(){
    GroupMenu.query(function(e){
      $scope.groups = e.result;
    });
  }
  $scope.loadGroup();

  // add project
  $scope.addProject = function(){
    $('#add-project').modal({
      closable: false,
      onDeny: function(){
        return true;
      },
      onApprove: function() {
        if(isValid($scope.aproject.Project.name)){
          $scope.saveAddProject();
          return false;
        }else{
          return false;
        }
      },
      onHide: function(){
        $scope.aproject = {};
      }
    }).modal('show');
  }
  $scope.saveAddProject = function(){
    Project.save($scope.aproject, function(e){
      if(e.response){
        message = {
          app: 'pm-tool',
          component: 'project-menu'
        }
        message = JSON.stringify(message);
        ws.send(message);
        $('#add-project').modal('hide');
      }
    });
  }
  // .add project
  
});