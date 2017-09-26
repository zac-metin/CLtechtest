var nock = require('nock')
var request = require('request')

var app = require('../app.js')

var testObj = {
  test: "Yes"
}

describe('Testing GET route functions', () => {
  test('apiCall function makes api call', () => {
    let scope = nock('https://sandbox-quickbooks.api.intuit.com/v3/company/')
      .get('/api_call')
      .reply(200, testObj)

    request(app)
      .get('https://sandbox-quickbooks.api.intuit.com/v3/company/68659484')
      .expect(200)
      .then((res) => {
        scope.done()
        expect(res).toEqual(testObj)
      })
  })
});
