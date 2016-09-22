<?php
/**
 * Created by PhpStorm.
 * User: san
 * Date: 10/3/2015
 * Time: 1:15 PM
 */

namespace App\Config {

    use Minute\Composer\Setup;

    class Plugins {
        /**
         * @param $event
         */
        public static function installPlugin($event) {
            self::setupPlugin($event, 'install');
        }

        public static function removePlugin($event) {
            self::setupPlugin($event, 'uninstall');
        }

        private static function setupPlugin($event, $type) {
            //print "SETUP: 1\n";

            if ($autoloader = realpath(__DIR__ . '/../../vendor/autoload.php')) {
                if (require_once($autoloader)) {
                    if (is_callable(['Minute\Composer\Setup', 'setupPlugin'])) {
                        return call_user_func(['Minute\Composer\Setup', 'setupPlugin'], $event, $type);
                    }
                }
            }

            #print "PLUGIN INSTALLER IS NOT CALLABLE!\n";
            return false;
        }
    }
}