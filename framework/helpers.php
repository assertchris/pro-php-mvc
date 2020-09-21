<?php

use Framework\View;

if (!function_exists('view')) {
    function view($path, $data = [])
    {
        static $manager;

        if (!$manager) {
            $manager = new View\Manager();

            // let's add a path for our views folder
            // so the manager knows where to look for views
            $manager->addPath(__DIR__ . '/../resources/views');

            // we'll also start adding new engine classes
            // with their expected extensions to be able to pick
            // the appropriate engine for the template
            $manager->addEngine('basic.php', new View\Engine\BasicEngine());
        }

        return $manager->render($path, $data);
    }
}
