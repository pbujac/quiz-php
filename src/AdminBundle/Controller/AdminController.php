<?php


namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
     */
    public function adminAction()
    {
        return $this->render('AdminBundle:admin:admin.html.twig');
    }
}
