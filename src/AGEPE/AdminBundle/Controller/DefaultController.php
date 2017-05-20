<?php

namespace AGEPE\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/home/",name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $date=new \DateTime("now");

        $employee = $em->getRepository('AGEPEAdminBundle:Employee')->findAll();

        $holiday = $em->getRepository('AGEPEAdminBundle:Holiday')
            ->findOneByHolidayDate($date);

        $dailyWork= $em->getRepository('AGEPEAdminBundle:DailyWorkJournal')
            ->findByAsDate($date);

        $employeeActive=$em->createQueryBuilder()->select('a')
            ->from('AGEPEAdminBundle:Employee', 'a')
            ->andwhere(':date >= a.joinDate ')
            ->andwhere('a.departureDate IS NULL OR :date <= a.departureDate')
            ->setParameter('date',$date)
            ->getQuery()
            ->getResult();

        $paidLeave=$em->createQueryBuilder()->select('a')
            ->from('AGEPEAdminBundle:PaidLeave', 'a')
            ->andwhere(':date BETWEEN a.fromDate AND a.toDate  ')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();

        return $this->render('AGEPEAdminBundle:Default:index.html.twig',
            array('sizeOfEmployee'=>sizeof($employee)
                    ,'isHoliday'=>$holiday
                    ,'dailyWork'=>$dailyWork
                    ,'activeEmployee'=>$employeeActive
                    ,'dateNow'=>$date
                    ,'sizePaidLeave'=>sizeof($paidLeave)));
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
