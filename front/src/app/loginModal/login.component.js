(function () {
  'use strict';

  angular.module('app').component('login', {
    controller: LoginController,
    controllerAs: 'vm',
    templateUrl: 'app/loginModal/login.view.html',
  });

  /** @ngInject */
  function LoginController($log, $rootScope, $window, $state , md5, webservices) {
    const vm = this;

    vm.login = login;
    vm.openModal = openModal;

    vm.showModal = false;
    vm.email = '';
    vm.password = '';

    $rootScope.$on('OPEN_LOGIN', openModal);
    
    function openModal() {
      vm.showModal = !vm.showModal;  
    }

    function login() {
      console.log(md5);

      if (vm.email && vm.password) {
        var crytedPass = md5.createHash(vm.password);
        webservices.getUser(vm.email, crytedPass)
          .then(function(data) {
            
            if (!data.Error) {
              $window.localStorage.setItem("userData", JSON.stringify(data));
              $state.go('dashboard');
              openModal();
            }
          }, function(err) {
              $log.error(err);
          });
      }
      
    }
  }

})();