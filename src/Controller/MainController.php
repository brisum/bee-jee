<?php

namespace App\Controller;

use App\Utils\View;

class MainController
{
    public function indexAction(
        View $view
    ) {

        $view->render(
            'main.php'
        );
    }
}
