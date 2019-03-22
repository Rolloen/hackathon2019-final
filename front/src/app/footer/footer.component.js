(function() {
  'use strict';

  angular.module('app').component('footer', {
    controller: FooterController,
    controllerAs: 'vm',
    templateUrl: 'app/footer/footer.view.html',
  });

  /** @ngInject */
  function FooterController() {
    const vm = this;

  }

})();
