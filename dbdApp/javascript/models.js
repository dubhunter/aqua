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

var hyEvents = {
	all: function (page, perpage) {
		var data = {
			'page': page || 0
		};
		if (perpage) {
			data.perpage = perpage;
		}
		return hyduinoApi.get('/v1/events', data);
	},
	get: function (id) {
		return hyduinoApi.get('/v1/events/' + id);
	},
	create: function (data) {
		return hyduinoApi.post('/v1/timers', data);
	}
};

var hyTimers = {
	all: function (page, perpage) {
		var data = {
			'page': page || 0
		};
		if (perpage) {
			data.perpage = perpage;
		}
		return hyduinoApi.get('/v1/timers', data);
	},
	get: function (id) {
		return hyduinoApi.get('/v1/timers/' + id);
	},
	create: function (data) {
		return hyduinoApi.post('/v1/timers', data);
	},
	update: function (id, data) {
		return hyduinoApi.post('/v1/timers/' + id, data);
	}
};

var hyTriggers = {
	all: function (page, perpage) {
		var data = {
			'page': page || 0
		};
		if (perpage) {
			data.perpage = perpage;
		}
		return hyduinoApi.get('/v1/triggers', data);
	},
	get: function (id) {
		return hyduinoApi.get('/v1/triggers/' + id);
	},
	create: function (data) {
		return hyduinoApi.post('/v1/triggers', data);
	},
	update: function (id, data) {
		return hyduinoApi.post('/v1/triggers/' + id, data);
	}
};