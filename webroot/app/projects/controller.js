app.controller('ProjectController', function($scope, $routeParams, Project){

});

app.controller('ProjectViewController', function($scope, $timeout,  $routeParams, Project, SelectMember, ProjectMember, ProjectMessage, Task, ProjectId){
  $scope.ws = new WebSocket(wsUrl);
  $scope.ws.onmessage = function(e){
    res = JSON.parse(e.data);
    if(res.app == 'pm-tool' && res.component == 'project-messages'){
      if(res.projectId == $scope.projectId){
        $timeout(function(){$scope.project.Message.unshift(res.data);},0);
      }
    }else if(res.app == 'pm-tool' && res.component == 'project-members'){
      if(res.data.projectId == $scope.projectId){
        $scope.loadMember();
      }
    }
  }

  $('.menu .item').tab();
  $('.required-pop').popup({popup:$('.custom.popup'), on:'focus'});
  
  ProjectId.get({slug:$routeParams.slug}, function(p){
    $scope.projectId = p.result;
    Project.get({id:$scope.projectId}, function(e){
      $scope.project = e.result;
      $scope.project.MemberSelection = $scope.project.MemberSelection;
      $timeout(function(){
        $('#project-progress').progress();
        $('.aprojectmember-member_id').dropdown();
      }, 100);
    });
    // new message variable
    $scope.newmessage = {ProjectMessage:{member_id: memberdata.id,project_id: $scope.projectId,message: ''}}
  });
  

  // load messages
  $scope.loadMessage = function(){
    Project.get({id:$scope.projectId, action:'messages'}, function(e){
      $scope.project.Message = e.result.Message;
    });
  }
  
  // load members
  $scope.loadMember = function(){
    Project.get({id:$scope.projectId, action:'members'}, function(e){
      $scope.project.Member = e.result.Member;
      $scope.project.MemberSelection = e.result.MemberSelection;
      $('.aprojectmember-member_id .text').text('Select Member');
    });
  }
  
  // add member
  $scope.addMember = function(){
    $scope.aprojectmember = {ProjectMember:{project_id:$scope.projectId}};
    $('#add-member').modal('show');
  }
  $scope.saveAddMember = function(){
    ProjectMember.save($scope.aprojectmember, function(e){
      if(e.response){
        message = {
          app:'pm-tool', component:'project-members',
          data:{
            type: 'add',
            projectId:$scope.aprojectmember.ProjectMember.project_id,
            memberId:$scope.aprojectmember.ProjectMember.member_id,
            projectName: $scope.project.Project.name
          }
        };
        message = JSON.stringify(message);
        $scope.ws.send(message);
        $scope.aprojectmember = {ProjectMember:{project_id:$scope.projectId}};
      }
    });
  }
  // .add member
  
  // edit member
  $scope.editMember = function(member){
    $scope.emember = member;
    $('#edit-member').modal({
      closable: false,
      onDeny: function(){
        $scope.deleteMember(member);
        return false;
      },
      onApprove: function() {
        return false;
      }
    }).modal('show');
  }
  $scope.saveEditMember = function(){

  }
  // .edit member
  // delete member
  $scope.deleteMember = function(member){
    ProjectMember.remove({id:member.id}, function(e){
      if(e.response){
        message = {app:'pm-tool', component:'project-members', data:{type: 'delete', projectId: $scope.projectId, memberId: member.member_id, projectName: $scope.project.Project.name}};
        message = JSON.stringify(message);
        $scope.ws.send(message);
        $('#edit-member').modal('hide');
      }
    });
  }
  // .delete member
  
  
  // view task
  $scope.taskstatus = ['In progress', 'Testing', 'Done'];
  $scope.viewTask = function(task){
    
    $scope.vtask = task;
    $scope.dtask = task;
    Task.get({id:task.id}, function(e){
      $scope.utask = e.result;
      if($scope.utask.due_date != null) $scope.utask.due_date = Date.parse($scope.utask.due_date).toString('yyyy-MM-dd');
      if($scope.utask.member_id == null){
        delete $scope.utask.member_id;
        $('.vtask-member .text').text('');
      }else{ 
        $('.vtask-member .text').text($scope.utask.assigned_to);
        $('.vtask-member .text').removeClass('default');
      }
      $timeout(function(){ $('.vtask-status').dropdown(); }, 0);
      
    });
    $('#view-task').modal({
      closable: false,
      onApprove: function() {
        return false;
      },
      onHide: function(){
        $scope.utask = {};
      }
    }).modal('show');
  }
  $scope.select = function(str, val) {
    eval(str + ' = val;');      
  };
  // .view task
  // add task
  $scope.addTask = function(){
    $scope.atask = {
      Task: {
        project_id:$scope.projectId,
        name: null
      }
    };
    
    $('#add-task').modal({
      closable: false,
      onDeny: function(){
        return true;
      },
      onApprove: function() {
        if($scope.atask.Task.name == null || $scope.atask.Task.name == ''){
          return false
        } else {
           $scope.saveAddTask();
        }
      },
      onHide: function(){
        $('.atask-member .text').text('');
      }
    }).modal('show');
  }
  
  $scope.saveAddTask = function(){
    Task.save($scope.atask, function(e){
      if(e.response){
        $scope.project.Task.unshift(e.data);      
        $('#add-task').modal('hide');
      }
    });
  }
  // add sub task
  $scope.addSubTask = function(task){
    $scope.atask = {
      Task: {
        project_id:$scope.projectId,
        name: null,
        parent: task.id
      }
    };
    $scope.subtaskParent = task.code + ' - ' + task.name;
    $('#add-sub-task').modal({
      closable: false,
      onDeny: function(){
        return true;
      },
      onApprove: function() {
        if($scope.atask.Task.name == null || $scope.atask.Task.name == ''){
          return false
        } else {
          Task.save($scope.atask, function(e){
            if(e.response){
              $scope.project.Task[$scope.project.Task.indexOf($scope.vtask)] = e.data;  
              $('#add-sub-task').modal('hide');
            }
          });
        }
      },
      onHide: function(){
        $('.atask-member .text').text('');
        $scope.subtaskParent = '';
      }
    }).modal('show');
  }

  // .add task
  // update task
  $scope.updateTask = function(task){
    Task.update({id:$scope.utask.id}, {
      Task: {
        id: $scope.utask.id,
        member_id: $scope.utask.member_id,
        name: $scope.utask.name,
        description: $scope.utask.description,
        due_date: $scope.utask.due_date,
        status: $scope.utask.status,
        parent: $scope.utask.parent
      }
    }, function(e){
      if(e.response){
        if(task.parent == null || task.parent == ''){
          $scope.project.Task[$scope.project.Task.indexOf($scope.vtask)] = e.data;
        }else{
          index = $('[data-project-task-id='+ e.data.id +']').data('project-task-index');
          $scope.project.Task[index] = e.data;
        }
        
        $('#view-task').modal('hide');
      }
    });
  }
  // .update task
  // delete task
  $scope.deleteTask = function(task){
    msg = confirm('Are you sure you want to delete ' + task.name + '?');
    if(msg){
      Task.remove({id:task.id}, function(e){
        if(e.response){
          //$scope.project.Task.splice($scope.project.Task.indexOf(task),1);
          $('[data-project-task-id='+ e.data.id +']').remove();
          $('#view-task').modal('hide');
        }
      });
    }
  }
  // .delete task
  
  

  // new message
  $('#message-area').keypress(function(event) {
    if (event.keyCode == 13 && !event.shiftKey) {
      $scope.sendMessage();
      return false;
     }
  });
  
  $scope.sendMessage = function(){
    if($scope.newmessage.ProjectMessage.message != ''){
      ProjectMessage.save($scope.newmessage, function(e){
        $scope.newmessage.ProjectMessage.message = '';
        if(e.response){
          message = {
            app: 'pm-tool',
            component: 'project-messages',
            projectId: $scope.projectId,
            data: e.data
          }
          message = JSON.stringify(message);
          $scope.ws.send(message);
        }
      });
    }
  }
  // .new message
  
  
  setInterval(function(){
    $scope.loadMessage();
  }, 60000);

});