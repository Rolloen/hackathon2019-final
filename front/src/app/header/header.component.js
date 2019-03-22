(function() {
  'use strict';

  angular.module('app').component('header', {
    controller: HeaderController,
    controllerAs: 'vm',
    templateUrl: 'app/header/header.view.html',
  });

  /** @ngInject */
  function HeaderController($rootScope, $window, $state) {
    const vm = this;

    vm.openLoginModal = openLoginModal;
    vm.isConnected = isConnected;
    vm.logout = logout;

    vm.userInfo = {};

    init();

    function init() {
      var userData = $window.localStorage.getItem('userData');
      if (userData && userData !== 'null') {
        vm.userInfo = JSON.parse(userData);
        console.log(vm.userInfo);
        
      }
    }

    function isConnected() {
      var userData = $window.localStorage.getItem('userData');
      return userData;
    }

    function openLoginModal() {
      $rootScope.$broadcast('OPEN_LOGIN');
    }

    function logout() {
      $window.localStorage.setItem('userData', null);
      $state.go('home');
    }
  }

})();
