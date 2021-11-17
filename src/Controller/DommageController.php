<?php

namespace App\Controller;

class DommageController extends AbstractController
{
    public function message()
    {
        return $this->twig->render('Dommage/dommage.html.twig');

    }


}