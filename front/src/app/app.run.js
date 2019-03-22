(function() {
  'use strict';

  angular.module('app').run(runBlock);

  /** @ngInject */
  function runBlock($document, $log, $rootScope, $window, tmhDynamicLocale, amMoment) {
    	amMoment.changeLocale('fr');

    // $rootScope.$on('$translateChangeSuccess', function(event, data) { // eslint-disable-line angular/on-watch
    //   tmhDynamicLocale.set(data.language);
    //   $document[0].documentElement.setAttribute('lang', data.language);
    // });

    $rootScope.$on('$stateChangeStart', function (evt, to, params) {
      var userData = $window.localStorage.getItem('userData');
      console.log(userData);
      
      if (to.requiresLogin && (!userData || userData === 'null')) {
        evt.preventDefault();
        $rootScope.$broadcast('OPEN_LOGIN');
        // $state.go(to.redirectTo, params, {
        //   location: 'replace'
        // });
      }
    });

    $log.debug('App run block end');
  }

})();
