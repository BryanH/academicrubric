'use strict';

/**
 * @ngdoc overview
 * @name adrateApp
 * @description
 * # adrateApp
 *
 * Main module of the application.
 */
angular
  .module('adrateApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl',
        controllerAs: 'main'
      })
      .when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl',
        controllerAs: 'about'
      })
      .otherwise({
        redirectTo: '/'
      });
  })
  /* Toggle 'active' class on elements when clicked
  from: http://stackoverflow.com/a/17933304
  */
  .directive( 'toggleClass', function() {
    var directiveObject = {
      restrict: 'A', // only matches attribute name
      template: '<li ng-class="active" ng-click="localFunction()" ng-transclude></li>',
      replace: true,
      scope: {
        model: '='
      },
      transclude: true,
      link: function( scope, element, attributes ) {
        scope.localFunction = function() {
          scope.model.value = scope.$id;
        };
        // When current element is the scope, set as active
        scope.$watch( 'model.value', function() {
          if( scope.model.value == scope.$id ) {
            scope.selected = 'active';
          } else {
            scope.selected = '';
          }
        });
      }
    };

    return directiveObject;
  });
