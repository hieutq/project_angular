var link=$('meta[name="website"]').attr('content');
var app = angular.module('my-app',['ngFileUpload']).constant('API',link);
