<?php


namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="admin.dashboard")
     */
    public function adminAction()
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
