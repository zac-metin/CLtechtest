var $ = require('jquery')

function apiCall() {
  $("#readresult").html('Loading...')
  $.get("/api_call", function(data) {
    $("#readresult").html(JSON.stringify(data, null, 2))
  })
}

function apiRead() {
  $("#readresult").html('Fetching Resource')
  $.get(`/api_call/resourceName/${resourceName}/entityID/${entityID}`, function(data) {
    $("#readresult").html(JSON.stringify(data, null, 2))
  })
}

function apiQuery() {
  $("#queryresult").html('Fetching Resource')
  $.get(`/api_call/query/${queryStatement}`, function(data) {
    $("#queryresult").html(JSON.stringify(data, null, 2))
  })
}

function apiCreate() {
  $("#createresult").html('Fetching Resource')
  $.post(`/api_call/create/${createName}`, createBody, function(data) {
    $("#createresult").html(JSON.stringify(data, null, 2))
  })
}
function apiDelete() {
  $("#createresult").html('Fetching Resource')
  $.post(`/api_call/delete/${createName}`, function(data) {
    $("#createresult").html(JSON.stringify(data, null, 2))
  })
}

module.exports = {
  apiCall,
  apiRead,
  apiQuery,
  apiCreate,
  apiDelete
}
