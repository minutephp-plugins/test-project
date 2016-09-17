<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\ActiveTheme {

    use App\Model\Blog;
    use Minute\View\View;

    class Homepage {

        public function index($_blogs) {
            /** @var Blog $blog */
            if (!empty($_blogs)) {
                $blog           = $_blogs[0];
                $stories        = $blog->stories;
                $story          = $stories[0];
                $story->content = 'test best';
            }

            return (new View());
        }
    }
}