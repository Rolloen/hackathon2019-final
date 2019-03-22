(function () {
  'use strict';

  angular.module('app').component('faq', {
    controller: FaqController,
    controllerAs: 'vm',
    templateUrl: 'app/faq/faq.view.html',
  });

  /** @ngInject */
  function FaqController() {

  }

})();