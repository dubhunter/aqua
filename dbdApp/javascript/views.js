bView.DEFAULT = 'hyduinoView';

var hyduinoView = bView.extend({
	init: function (){
		this.initLinks();
	},
	initLinks: function (){
		var submit = function (e){
			e.preventDefault();
			var $a = $(this);
			if ($a.is('.disabled') || $a.is('.loading') || $a.attr('disabled')) {
				return false;
			}
			bRunner.clearTimed();
			switch (true) {
				case $a.is('@post'):
					$a.addClass('loading');
					bourbon.run(e, $a.attr('href'), 'post');
					break;
				case $a.is('@put'):
					$a.addClass('loading');
					bourbon.run(e, $a.attr('href'), 'put');
					break;
				case $a.is('@delete'):
					$a.addClass('loading');
					bourbon.run(e, $a.attr('href'), 'destroy');
					break;
				default:
					History.pushState(null, $a.attr('title'), $a.attr('href'));
					break;
			}
			return false;
		};
		this.node.on('click', 'a[href^="/"]', submit);
//		this.node.find('a[href^="http"],a[href^="ssh"]').append('&nbsp;<i class="icon icon-share"></i>');
	}
});

var viewPowerButtons = hyduinoView.extend({
	init: function () {
		this.parent();
		this.node.on('click', 'a', function (e) {
			$(this).find('i').attr('class', 'icon-refresh icon-spin');
		});
	}
});