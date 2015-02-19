<?php

namespace SB\FormulaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SBFormulaireBundle:Default:index.html.twig', array('name' => $name));
    }
}
