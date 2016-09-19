<?php

namespace akerbel\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('akerbelManagerBundle:Default:index.html.twig');
    }
}
