app.filter('fromNow', function() {
  return function(date) {
     return moment(new Date(date)).fromNow();
  }
});