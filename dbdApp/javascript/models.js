var aquaApi = new bApi();

var aquaApiOptions = function (){
	return aquaApi.options('/*');
};

var hyPower = {
	status: function () {
		return aquaApi.get('/v1/power');
	},
	on: function () {
		return aquaApi.post('/v1/power', {'status': 'on'});
	},
	off: function () {
		return aquaApi.post('/v1/power', {'status': 'off'});
	}
};

var hyEvents = {
	all: function (event, page, perpage) {
		var data = {
			'page': page || 0
		};
		if (perpage) {
			data.perpage = perpage;
		}
		if (event) {
			data.event = event;
		}
		return aquaApi.get('/v1/events', data);
	},
	range: function (event, date_from, date_to) {
		var data = {};
		if (event) {
			data.event = event;
		}
		if (date_from) {
			data.date_from = date_from;
		}
		if (date_to) {
			data.date_to = date_to;
		}
		return aquaApi.get('/v1/events', data);
	},
	get: function (id) {
		return aquaApi.get('/v1/events/' + id);
	},
	create: function (data) {
		return aquaApi.post('/v1/timers', data);
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
		return aquaApi.get('/v1/timers', data);
	},
	get: function (id) {
		return aquaApi.get('/v1/timers/' + id);
	},
	create: function (data) {
		return aquaApi.post('/v1/timers', data);
	},
	update: function (id, data) {
		return aquaApi.post('/v1/timers/' + id, data);
	},
	remove: function (id) {
		return aquaApi.destroy('/v1/timers/' + id);
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
		return aquaApi.get('/v1/triggers', data);
	},
	get: function (id) {
		return aquaApi.get('/v1/triggers/' + id);
	},
	create: function (data) {
		return aquaApi.post('/v1/triggers', data);
	},
	update: function (id, data) {
		return aquaApi.post('/v1/triggers/' + id, data);
	},
	remove: function (id) {
		return aquaApi.destroy('/v1/triggers/' + id);
	}
};