/// <reference path="E:/var/Dropbox/projects/minutephp/public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class DashboardController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
    }

    angular.module('DashboardApp', ['MinuteFramework', 'gettext'])
        .controller('DashboardController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', DashboardController]);
}
