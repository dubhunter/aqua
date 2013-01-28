var hyduinoApi = new bApi();

var hyduinoApiOptions = function (){
	return hyduinoApi.options('/*');
};

var hyPower = {
	status: function () {
		return hyduinoApi.get('/v1/power');
	},
	on: function () {
		return hyduinoApi.post('/v1/power', {'status': 'on'});
	},
	off: function () {
		return hyduinoApi.post('/v1/power', {'status': 'off'});
	}
};
