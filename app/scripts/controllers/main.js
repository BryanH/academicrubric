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
.controller('RatingController', ['$scope', '$rootScope', function( $scope, $rootScope ) {
					$scope.classes = [
						{name: 'Engl 1301', value:0, has_points: true},
						{name: 'Biol 2401', value:0, has_points: true},
						{name: 'Psyc 2301', value:0, has_points: true},
						{name: 'Knsg 1301', value:0, has_points: false},
						{name: 'Biol 2402', value:0, has_points: true},
						{name: 'Biol 2420', value:0, has_points: true},
						{name: 'Psyc 2314', value:0, has_points: true}
					];
					$scope.hesis = [
						{name: "AP", value:0},
						{name: "G", value:0},
						{name: "M", value:0},
						{name: "RC", value:0},
						{name: "Date", value:0, is_date: true}
					];
					$scope.teases = [
						{name: "R", value:0},
						{name: "M", value:0},
						{name: "S", value:0},
						{name: "E", value:0},
						{name: "Date", value:0, is_date: true}
					];
					$scope.bachelors = { name: 'bachelors', value:false };

					$scope.academicTotal = 0;
					$scope.teasTotal = 0;
					$scope.hesiTotal = 0;
					$scope.combinedTotal = 0;
					$scope.showHesiWarning = true;

					$rootScope.pageTitle = "Associate Degree Nursing";
					//		$scope.points = { startingPoints: 0 };

									// calculate academic
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

									// calculate hesi
									$scope.computeHesi = function() {
										var total = 0;
										var warning = true;
										for( var i = 0, len = $scope.hesis.length; i < len; i++ ) {
											// Skip date field
											if( $scope.hesis[i].is_date ) {
												continue;
											}
											// No HESI if any scores < 75
											if( $scope.hesis[i].value < 75 ) {
												warning = true;
												total = 0;
												break;
											}
											// If we get here, we're okay
											warning = false;
											total += hesiPoints( $scope.hesis[i].value );
										}
										$scope.hesiTotal = total;
										$scope.showHesiWarning = warning;
										$scope.computeTotal();
									}

									// calculate teas
									$scope.computeTeas = function() {
										var total = 0;
										for( var i = 0, len = $scope.teases.length; i < len; i++ ) {
											// Skip date field
											if( $scope.teases[i].is_date ) {
												continue;
											}

											total += teasPoints( $scope.teases[i].value );
										}
										$scope.teasTotal = total;
										$scope.computeTotal();
									}

									$scope.computeTotal = function() {
										var total = 0;
										total += $scope.hesiTotal;
										total += $scope.teasTotal;
										if( $scope.bachelors.value) {
											total++;
										}
										total += $scope.academicTotal;
										$scope.combinedTotal = total;
									}

									/*
									 Calculate points from HESI Scores
									*/
									function hesiPoints( hesiPercent ) {
										// Can't use a switch statement here
										var points = 0;
										if( hesiPercent >= 90 ) {
											points = 3;
										} else {
											if( hesiPercent >= 80 ) {
												points = 2;
											} else {
												// below 80 is zero points
											}
										}
										return points;
									}

									/*
									 Calculate points from TEAS scores
									*/
									function teasPoints( teasPercent ) {
										// Can't use a switch statement here
										var points = 0;
										if( teasPercent >= 83 ) {
											points = 3;
										} else {
											if( teasPercent >= 74 ) {
												points = 2;
											} else {
												if( teasPercent >= 64 ) {
													points = 1
												} else {
													// below 64 is zero points
												}
											}
										}
										return points;
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
}]);
