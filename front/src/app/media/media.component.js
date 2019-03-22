(function() {
  'use strict';

  angular.module('app').component('media', {
    controller: MediaController,
    controllerAs: 'vm',
    templateUrl: 'app/media/media.view.html',
  });

  /** @ngInject */
  function MediaController() {

  }

})();
