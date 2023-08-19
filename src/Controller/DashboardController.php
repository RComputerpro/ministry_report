<?php

namespace App\Controller;

use App\Repository\ReportsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Contracts\Translation\TranslatorInterface as TranslationTranslatorInterface;
use Twig\Environment;

//class DashboardController étend ReportController pour récupérer toutes les données utilisateur via getters

class DashboardController extends ReportController {

    /**
     * @var Environment
     */

    private $objHours;

    public function __construct(ReportsRepository $reportsRepository, Environment $twig, TokenStorageInterface $tsi, TranslationTranslatorInterface $translate)
    {
        parent::__construct($reportsRepository, $twig, $tsi, $translate);

        switch ($this->getUserConnected()->getStatut()) {
            case 'proclamateur':
                $this->objHours = 0;
                break;
            case 'pionnier_auxiliaire':
                $this->objHours = 30;
                break;
            case 'pionnier_permanent':
                $this->objHours = 50;
                break;
            case 'default':
                $this->objHours = 0;
                break;
        };
    }
    
    public function index():Response
    {
        return new Response($this->getTwig()->render('pages/dashboard.html.twig', [
            'firstname' => $this->getUserConnected()->getFirstname(),
            'name' => $this->getUserConnected()->getName(),
            'statut' => $this->getUserConnected()->getStatut(),
            'objHours' => $this->objHours,

            'month' => $this->getTodayMonth(),
            'hours' => $this->getHours(),
            'yearHours' => $this->getYearHours(),

            'publications' => $this->getPublications(),
            'videos' => $this->getVideos(),
            'nv_visites' => $this->getNvVisites(),
            'studies' => $this->getStudies()
        ]));
    }
}