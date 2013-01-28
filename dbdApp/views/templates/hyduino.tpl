<%* dbdSmarty *%>
<!DOCTYPE html>
<html lang=""en>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Will Mason" />
	<meta name="description" content="The Hyduino plant watering and monitoring system. Powerd by Twilio, Notifyr, Arduino, and bourbon.js" />

	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="/images/ico/favicon.png">

	<title>Hyduino</title>
</head>
<body id="hyduino-willandchi-com">
	<script type="text/javascript">
		var $this = {};
	</script>

	<%include file="global/throbber.handlebars"%>
	<%include file="global/page.handlebars"%>
	<%include file="global/header.handlebars"%>

	<%include file="home/dashboard.handlebars"%>
	<%include file="home/timers.handlebars"%>
	<%include file="home/alerts.handlebars"%>

</body>
</html>