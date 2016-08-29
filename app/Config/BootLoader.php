<?php
/**
 * Created by PhpStorm.
 * User: san
 * Date: 4/2/2016
 * Time: 6:13 AM
 */
namespace App\Config {

    class BootLoader {
        protected $baseDir;

        public function __construct() {
            $this->baseDir = realpath(__DIR__ . '/../../');
        }

        public function getBaseDir() {
            return $this->baseDir;
        }
    }
}