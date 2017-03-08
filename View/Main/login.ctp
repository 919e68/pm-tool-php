<div class="box" ng-controller="SigninController">
  <form name="loginForm">
    <div class="login-error" ng-repeat="(key, value) in formErrors" ng-cloak>{{ value }}</div>
    <div class="form-group" ng-class="{ 'danger': loginForm.username.$touched && loginForm.username.$invalid }">
      <label>Username</label>
      <input type="text" class="form-control" name="username" ng-model="user.username" ng-required="true">
    </div>

    <div class="form-group" ng-class="{ 'danger': loginForm.password.$touched && loginForm.password.$invalid }">
      <label>Password</label>
      <input type="password" class="form-control" name="password" ng-model="user.password" ng-required="true" autocomplete="off">
    </div>

    <div class="row">
      <div class="col-md-6">
        <a href="#" id="sign-up">Dont have an account ?</a>
        <a href="#" id="forgot">Forgotten password ?</a>
      </div>

      <div class="col-md-6">
        <button type="submit" id="sign-in" class="btn btn-primary btn-circle pull-right" ng-click="signIn()">Sign In</button>
      </div>
    </div>
  </form>
</div>