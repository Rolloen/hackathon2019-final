(function () {
  'use strict';

  angular.module('app').component('legal', {
    controller: LegalController,
    controllerAs: 'vm',
    templateUrl: 'app/legal/legal.view.html',
  });

  /** @ngInject */
  function LegalController() {

  }

})();