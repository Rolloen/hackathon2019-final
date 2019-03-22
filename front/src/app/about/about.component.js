(function () {
  'use strict';

  angular.module('app').component('about', {
    controller: AboutController,
    controllerAs: 'vm',
    templateUrl: 'app/about/about.view.html',
  });

  /** @ngInject */
  function AboutController() {

  }

})();