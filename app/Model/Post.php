<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 6/22/2016
 * Time: 8:22 AM
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class Post extends ModelEx {
        protected $table      = 'posts';
        protected $primaryKey = 'post_id';
    }
}