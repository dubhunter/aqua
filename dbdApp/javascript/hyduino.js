//@import jquery-1.7.2.js;
//@import jquery.ext.js;
//@import jquery.global.js;
//@import jquery.role.js;
//@import history.js;
//@import history.adapter.jquery.js;
//@import xregexp.js;
//@import handlebars.js;
//@import bourbon.js;
//@import bootstrap.js;
//@import bootstrapSwitch.js;
//@import pusher.min.js;
//@import highcharts.src.js;
//@import models.js;
//@import views.js;
//@import controllers.js;


bRouter.routes = {
	'^/$': 'homeController',
	'^/timers/?$': 'timersController',
	'^/timers/new$': 'timersCreateController',
	'^/timers/(?<id>[0-9]+)/?$': 'timersInstanceController',
	'^/alerts/?$': 'alertsController',
	'^/charts/?': 'chartsController',
	'^/power/?$': 'powerController'
};

var hyduino = {
	intervalTime: 1000,
	pusherKey: '562d02c947852152616a',
	pusherChannel: 'hyduino',
	pusherEvent: 'event',
	highchartsColors: [
		'#3a87ad'
	],
	power: function (status) {
		$this.power = (status == 'on');
		if ($('#powerButtons').length) {
			bView.update('powerButtons');
		}
		if ($('.timersRow').length && !$('.timersRow').is('.editing')) {
			bView.update('timersRow');
		}
	},
	light: function (status) {
		$this.power = (status == 'on');
		if ($('#powerButtons').length) {
			bView.update('powerButtons');
		}
	},
	handleEvents: function (event, data) {
		switch (event) {
			case 'power':
				hyduino.power(data)
		}
	},
	startEventSocket: function () {
		var pusher = new Pusher(hyduino.pusherKey);
		var channel = pusher.subscribe(hyduino.pusherChannel);
		channel.bind(hyduino.pusherEvent, function(payload) {
			hyduino.handleEvents(payload.event, payload.data);
		});
	}
};

//Handlebars.registerHelper('REALM', function (){
//	return REALM.ucfirst();
//});

Handlebars.registerHelper('power', function (options){
	if ($this.power) {
		return options.fn(this);
	} else {
		return options.inverse(this);
	}
});

$(function (){
	$(window).bind('statechange', function (e){
		bourbon.run(e);
	}).trigger('statechange');
});