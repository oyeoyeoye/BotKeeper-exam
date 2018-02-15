var http = require("http");
var url = require("url");

http.createServer(function(req, res) {
	var request = require("request");
	var q = url.parse(req.url, true).query;
	
	request({
		url: "http://api.openweathermap.org/data/2.5/weather?appid=d597693a03609500878eeed5636c671a&zip=" + q.zipcode,
		json: true
	}, function (error, response, body) {	
		var weather = { "description": null, 
						"temp"       : null,
						"humidity"   : null,
						"wind"       : null,
						"name"       : null };
		
		if (!error && response.statusCode === 200) {
			weather.description = body.weather[0].description;
			weather.temp = body.main.temp;
			weather.humidity = body.main.humidity;
			weather.wind = body.wind.speed;
			weather.name = body.name;
		}
		
		res.writeHead(200, { "Content-Type" : "application/json" });
		res.end(JSON.stringify(weather));
	});
}).listen(8080);