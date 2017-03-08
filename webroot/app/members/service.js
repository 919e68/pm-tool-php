app.factory("Member", function($resource) {
  return $resource( api + 'members/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});

app.factory("Message", function($resource) {
  return $resource( api + 'messages/:id', {id:'@id'}, {
    query: { method: 'GET', isArray: false },
    update: { method: 'PUT' }
  });
});


app.factory("SelectMember", function($resource) {
  return $resource( api + 'select/members', {}, {
    query: { method: 'GET', isArray: false }
  });
});

app.factory("OnlineUser", function($resource) {
  return $resource( api + 'select/onlineusers', {}, {
    query: { method: 'GET', isArray: false }
  });
});

app.factory("MemberId", function($resource) {
  return $resource( api + 'select/memberid/:user', {user:'@user'}, {
    query: { method: 'GET', isArray: false }
  });
});

