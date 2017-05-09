<?php

namespace AGEPE\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/hello/",name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        if($request->isMethod('post'))
        {
            var_dump("fuck");
            die();
        }

        return $this->render('AGEPEAdminBundle:Default:index.html.twig');
    }

    /**
     * @Route("/Ala/",name="Ala")
     * @Template()
     */
    public function indexAlaAction(Request $request)
    {
        if($request->isMethod('post'))
        {
            var_dump("fuck");
            die();
        }

        return $this->render('AGEPEAdminBundle:Default:indexAla.html.twig');
    }
}
