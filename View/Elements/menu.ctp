<div class="main-menu nano" ng-controller="MenuController">
  <div class="nano-content">
    <div class="ui inverted vertical menu">
      <div class="header item"><a href="#/projects">Projects</a></div>
      <a class="item" ng-repeat="project in projects" href="#/projects/{{ project.code }}">
        <span><i class="rocket icon"></i> {{ project.name  }}</span>
        <!-- <div class="ui red label">1</div> -->
      </a>
      <a class="item" href="javascript:void(0)" ng-if="memberRole == 'admin'" ng-click="addProject()"><span><i class="plus icon"></i> New Project</span></a>
      
      <div class="header item"><a href="#/members">Members</a></div>
      <a class="item" ng-repeat="member in members" href="#/messages/{{ member.code }}">
        <span><i class="male icon"></i> {{ member.name }}</span>
        <i class="circle icon" ng-if="!member.online"></i>
        <i class="green circle icon" ng-if="member.online"></i>
      </a>

      <div class="header item"><a href="#/groups">Groups</a></div>
      <a class="item" ng-repeat="group in groups" href="#/groups/{{ group.code }}">
        <span><i class="asterisk icon"></i> {{ group.name  }}</span>
        <!-- <div class="ui red label">1</div> -->
      </a>
      <a class="item" href="javascript:void(0)" ng-if="memberRole == 'admin'" ng-click="addGroup()"><span><i class="plus icon"></i> New Group</span></a>

      
      <div class="header item">Account</div>
      <a class="item" href="#/profile"><span><i class="spy icon"></i> Update Profile</span></a>
      <a class="item" href="<?php echo $this->base ?>/logout"><span><i class="lock icon"></i> Logout</span></a>
      
    </div>
  </div>
  <?php echo $this->element('modal/new-project') ?>
</div>



