'use strict';

/**
 * @ngdoc function
 * @name adrateApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the adrateApp
 */
angular.module('adrateApp')
  .controller('MainCtrl', function () {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  })
.controller('RatingController', function($scope) {
					$scope.classes = [
						{name: 'Engl 1301', value:0, has_points: true},
						{name: 'Biol 2401', value:0, has_points: true},
						{name: 'Psyc 2301', value:0, has_points: true},
						{name: 'Knsg 1301', value:0, has_points: false},
						{name: 'Biol 2402', value:0, has_points: true},
						{name: 'Biol 2420', value:0, has_points: true},
						{name: 'Psyc 2314', value:0, has_points: true}
					];
					$scope.bachelors = { name: 'bachelors', value:false };

					$scope.academicTotal = 0;
					$scope.combinedTotal = 0;
					$scope.program = "Associate Degree Nursing";
					//		$scope.points = { startingPoints: 0 };

									// TODO - calculate
									$scope.computeAcademic = function() {
										var total = 0;
										// Loop through all values
										for( var i = 0, len = $scope.classes.length; i < len; i++ ) {
											if( $scope.classes[i].has_points ) {
												// Use parseInt (base 10) to convert string to int
												total = total + parseInt( $scope.classes[i].value, 10 );
											}
										}
										$scope.academicTotal = total;
										$scope.computeTotal();
									};

									$scope.computeTotal = function() {
										var total = 0;
										if( $scope.bachelors.value) {
											total++;
										}
										total += $scope.academicTotal;
										$scope.combinedTotal = total;
									}
/*
							$scope.class.points.total = function() {
									var total = 0;
									for (var i = 0, len = $scope.classes.length; i < len; i++) {
											total = total + $scope.classes.value;
									}
									return total;
									}
									*/
});
