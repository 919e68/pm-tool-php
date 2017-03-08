<div class="ui small modal" id="add-project">
  <i class="close icon"></i>
  <div class="header">
    Add Project
  </div>
  <div class="content">
    <div class="ui form">
      <div class="required field">
        <label>Project Name</label>
        <input type="text" ng-model="aproject.Project.name">
      </div>
      <div class="field">
        <label>Description</label>
        <textarea type="text" placeholder="Description" ng-model="aproject.Project.description"></textarea>
      </div>
    </div>
  </div>
  <div class="actions">
    <button class="ui red right labeled icon deny button">Cancel <i class="remove icon"></i></button>
    <button class="ui green right labeled icon approve button">
      Save<i class="checkmark icon"></i>
    </button>
  </div>
</div>
