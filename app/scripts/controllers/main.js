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
		{name: 'Engl 1301', value:0, has_points: true, required: true},
		{name: 'Biol 2401', value:0, has_points: true, required: true},
		{name: 'Biol 2420', value:0, has_points: true, required: true},
		{name: 'Psyc 2301', value:0, has_points: true, required: true},
		{name: 'Biol 2402', value:0, has_points: true, required: false},
		{name: 'Psyc 2314', value:0, has_points: true, required: false},
		{name: 'Humanities/Fine Arts', value:0, has_points: true, required: false}
	];

	$scope.hesis = [
		{name: "A&P", value:0},
		{name: "Grammar", value:0},
		{name: "Math", value:0},
		{name: "Reading", value:0},
		{name: "Date", value:0, is_date: true}
	];

	$scope.teases = [
		{name: "Reading", value:0},
		{name: "Math", value:0},
		{name: "Science", value:0},
		{name: "Eng. Lang.", value:0},
		{name: "Date", value:0, is_date: true}
	];

	$scope.gpa = { name: "GPA", value: 0 };
	$scope.bachelors = { name: 'bachelors', value:false };

	$scope.academicTotal = 0;
	$scope.teasTotal = 0;
	$scope.hesiTotal = 0;
	$scope.combinedTotal = 0;
	$scope.showHesiWarning = true;
	$scope.showTeasWarning = true;

	$scope.ignoreTeas = false;

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
		var warning = true;
		for( var i = 0, len = $scope.teases.length; i < len; i++ ) {
			// Skip date field
			if( $scope.teases[i].is_date ) {
				continue;
			}
			// No TEAS if any scores < 64
			if( $scope.teases[i].value < 64 ) {
				warning = true;
				total = 0;
				break;
			}

			// If we get here, we're okay
			warning = false;
			total += teasPoints( $scope.teases[i].value );
		}
		$scope.teasTotal = total;
		$scope.showTeasWarning = warning;
		$scope.computeTotal();

	}

	$scope.computeTotal = function() {
		var total = 0;
		if( $scope.ignoreTeas) {
			total += $scope.hesiTotal;
		} else {
			total += $scope.teasTotal;
		}
		if( $scope.bachelors.value) {
			total++;
		}

		if( $scope.gpa.value >= 3.0) {
			total += gpaPoints( $scope.gpa.value );
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
		Calculate points based upon GPA
		*/
	function gpaPoints( gpa ) {
		var points = 0;
		if( gpa >= 3.800 && gpa <= 4.000 ) {
			points = 5;
		} else {
			if( gpa >= 3.600 && gpa <= 3.799 ) {
				points = 4;
			} else {
				if( gpa >= 3.400 && gpa <= 3.599 ) {
					points = 3;
				} else {
					if( gpa >= 3.200 && gpa <= 3.399 ) {
						points = 2;
					} else {
						if( gpa >= 3.000 && gpa <= 3.199 ) {
							points = 1;
						} else {
							// No points for < 3.000
						}
					}
				}
			}
		}
		return points;
	}

	/* Called when HESI has been selected
	*/
	$scope.calcHesi = function() {
		$scope.ignoreTeas = true;
		console.log("use HESI");
		$scope.computeTotal();
	}

	/* Called when TEAS has been selected
	*/
	$scope.calcTeas = function() {
		$scope.ignoreTeas = false;
		console.log("use TEAS");
		$scope.computeTotal();
	}

	/* Calculate points based upon GPA
	 @param gpa Float of gpa, to thousanths
	 @returns point score
	 */
	function gpaPoints( gpa ) {
		var points = 0;
		if( gpa >= 3.800 && gpa <= 4.000 ) {
			points = 5;
		} else {
			/* We don't need an upper-bound because that is
			   covered by the previous 'if' statement */
			if( gpa >= 3.600 ) {
				points = 4;
			} else {
				if( gpa >= 3.400 ) {
					points = 3;
				} else {
					if( gpa >= 3.200 ) {
						points = 2;
					} else {
						if( gpa >= 3.000 ) {
							points = 1;
						}
					}
				}
			}
		}
		return points;
	}

}]);
