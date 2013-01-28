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
//@import notifyr.js;
//@import models.js;
//@import views.js;
//@import controllers.js;


bRouter.routes = {
	'^/$': 'homeController',
	'^/schedule$': 'scheduleController',
	'^/alerts$': 'alertController',
	'^/power$': 'powerController'
};

var hyduino = {
	intervalTime: 1000,
	notifyrApiKey: 'CpBTzZAqxDRDVlLJJEKqOih0JZhmGdPA4F8Zbyr2ByA',
	power: function (status) {
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
	startEventListener: function () {
		var notifyr = new Notifyr(hyduino.notifyrApiKey, {ssl: true});
		var channel = notifyr.subscribe('hyduino');
		channel.listen(function(payload) {
			payload = $.parseJSON(payload);
			hyduino.handleEvents(payload.event, payload.data);
		});
	}
};

//Handlebars.registerHelper('REALM', function (){
//	return REALM.ucfirst();
//});
//
//Handlebars.registerHelper('curtain', function (options){
//	if ($this.curtain) {
//		return options.fn(this);
//	} else {
//		return options.inverse(this);
//	}
//});

$(function (){
	$(window).bind('statechange', function (e){
		bourbon.run(e);
	}).trigger('statechange');
});