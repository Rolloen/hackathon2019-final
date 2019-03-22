(function () {
  'use strict';

  angular.module('app').component('dashboardPage', {
    controller: DashboardController,
    controllerAs: 'vm',
    templateUrl: 'app/dashboard/dashboard.view.html',
  });

  /** @ngInject */
  function DashboardController($log, $scope, $window, webservices, moment) {
    const vm = this;

    vm.changeSelectedDate = changeSelectedDate;

    vm.selectedRegion = {};
    vm.stats = {};
    vm.limitDate = getDateWithSubstract(1, 'weeks');
    vm.selectedDate = "1week";

    var today = moment().format('YYYY-MM-DD');

    activate();

    function activate() {
      console.log(today);
      
      initStats();
      var width = 1000,
        height = 1000,
        centered;

      var path = $window.d3.geoPath();

      var projection = $window.d3.geoConicConformal()
        .center([2.454071, 46.279229])
        .scale(5000)
        .translate([width / 2, height / 2]);

      path.projection(projection);

      var svg = $window.d3.select('#map').append("svg")
        .attr("id", "svg")
        .attr("width", width)
        .attr("height", height);

      var deps = svg.append("g");

      $window.d3.json('app/assets/geocoding/franceDepartement.json').then(function (geojson) {
        deps.selectAll("path")
          .data(geojson.features)
          .enter()
          .append("path")
          .attr("d", path)
          .attr('class', 'departement')
          .on("click", departClicked);
          // .on("mouseover", handleHover);

      });

      function departClicked(d) {
        if (d && centered !== d) {
          centered = d;
          vm.selectedRegion = d.properties;
        } else {
          centered = null;
          vm.selectedRegion = {};

        }

        deps.selectAll("path")
          .classed("selected", centered && function (d) {
            return d === centered;
          });
          
        $scope.$apply(vm.selectedRegion);
        initStats();
        $scope.$broadcast('DATE_CHANGED', vm.limitDate);
      }

    }
    function initStats() {
      webservices.getNationalStats(vm.limitDate, today, vm.selectedRegion.nom)
        .then(function(data){
          vm.stats = data;          
        }, function (err) {
            $log.error(err);          
        });
    }

    function getDateWithSubstract(nb, typeOfDuration) {
      return moment().subtract(nb, typeOfDuration).format('YYYY-MM-DD');
    }

    function changeSelectedDate(date, nb, typeOfDuration) {
      vm.selectedDate = date;
      vm.limitDate = getDateWithSubstract(nb, typeOfDuration);
      initStats();
      $scope.$broadcast('DATE_CHANGED', vm.limitDate);
    }

  }

})();