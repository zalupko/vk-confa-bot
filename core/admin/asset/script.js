var main = {};
(function(context) {
	var id = 0;
	
	context.helloWorld = function() {
		console.log('Hello World');
	};
})(main);

window.onload = function () {
	main.helloWorld();
}