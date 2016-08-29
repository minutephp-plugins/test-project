<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 6/22/2016
 * Time: 8:22 AM
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class Blog extends ModelEx {
        protected $table      = 'blogs';
        protected $primaryKey = 'blog_id';
    }
}