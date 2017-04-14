var link=$('meta[name="website"]').attr('content');
var app = angular.module('my-app',[]).constant('API',link);
