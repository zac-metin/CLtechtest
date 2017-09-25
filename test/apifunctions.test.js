var nock = require('nock')

var api = require('./apifunctions.js')

var testObj = {
  test: "returned test obj"
}

describe('Testing GET route functions', () => {
  test('apiCall', ()=> {
    api.apiCall()
    var hello = "hello"
    expect(hello).toEqual("hello")
  })

  test('apiCall function makes api call', () => {
    let scope = nock('http://localhost:3000')
    .get('/api_call')
    .reply(200, testObj)
  api.apiCall()
    .then((res) => {
      scope.done()
      expect(res).toEqual(testObj)
    })
  })

});
