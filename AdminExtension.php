<?php

namespace Adevo\AdminBundle\Twig\Extension;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\Security\Core\SecurityContext;

class AdminExtension extends \Twig_Extension {

    /**
     * @var Doctrine
     */
    private $doctrine;

    /**
     * @var SecurityContext
     */
    private $securityContext;

    /**
     *
     * @var \Twig_Environment
     */
    private $environment;
    private $companyTopList;
    private $newsTopList;

    function __construct(Doctrine $doctrine, SecurityContext $securityContext) {
        $this->doctrine = $doctrine;
        $this->securityContext = $securityContext;
    }

    public function initRuntime(\Twig_Environment $environment) {
        $this->environment = $environment;
    }

    public function getName() {
        return 'adevo_admin_extension';
    }

    public function getFilters() {
        return array(
            'admin_format_date' => new \Twig_Filter_Method($this, 'adminFormatDate')
        );
    }

    public function adminFormatDate(\DateTime $datetime) {
        return $datetime->format('d.m.Y, H:i:s');
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('print_main_menu_admin', array($this, 'printMainMenu'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('print_top_menu_admin', array($this, 'printTopMenu'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('print_notifications_news_admin', array($this, 'printNotificationsNewsAdmin'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('print_notifications_company_admin', array($this, 'printNotificationsCompanyAdmin'), array('is_safe' => array('html'))),
        );
    }

    public function printMainMenu() {

        return $this->environment->render('AdevoAdminBundle:Template:mainMenu.html.twig', array(
        ));
    }

    public function printTopMenu() {

        return $this->environment->render('AdevoAdminBundle:Template:topMenu.html.twig', array(
        ));
    }

    public function printNotificationsNewsAdmin() {
        
        $NewsRepo = $this->doctrine->getRepository('AdevoNewsBundle:Post');
        $queryParamsNews = array(
            'orderDir' => 'DESC',
            'today' => 'date'
        );

        $this->newsTopList = $NewsRepo->getQueryBuilder($queryParamsNews);
        return $this->environment->render('AdevoAdminBundle:Template:notificationsAdmin.html.twig', array(
                    'postList' => $this->newsTopList->getQuery()->getResult(),
                    'sectionTitle' => 'Newsy'
        ));
    }
    
    public function printNotificationsCompanyAdmin() {
        
        $CompanyRepo = $this->doctrine->getRepository('AdevoCompaniesBundle:Company');
        $queryParamsNews = array(
            'status' => 'published',
            'orderDir' => 'DESC',
            'today' => 'date'
        );

        $this->companyTopList = $CompanyRepo->getQueryBuilder($queryParamsNews);
        return $this->environment->render('AdevoAdminBundle:Template:notificationsAdmin.html.twig', array(
                    'postList' => $this->companyTopList->getQuery()->getResult(),
                    'sectionTitle' => 'Baza Firm'
        ));
    }

}