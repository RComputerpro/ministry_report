<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ReportsRepository;
use DateInterval;
use DateTime;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class ReportController extends AbstractController {

    /**
     * @var Environment
     */

    private $twig;
    private $today;
    private $username;
    private $name;
    private $todayMonth;

    //donnees totales du mois

    private $hours;
    private $yearHours;
    private $yearData;

    private $publications;
    private $videos;
    private $nv_visites;
    private $studies;
    private $userConnected;

    private $reports_reporistory;


    public function __construct(ReportsRepository $reports_reporistory, Environment $twig, TokenStorageInterface $tsi, TranslatorInterface $translate) 
    {
        $this->twig = $twig;
        $this->today = new DateTime();
        $this->todayMonth = $this->today->format('F');
        $this->todayMonth = $translate->trans($this->todayMonth, domain:'month');
        $this->hours = new DateInterval('P0DT0H0M');
        $this->yearHours = new DateInterval('P0DT0H0M');

        $this->yearData = array();

        $this->publications = 0;
        $this->videos = 0;
        $this->nv_visites = 0;
        $this->studies = 0;

        $this->reports_reporistory = $reports_reporistory;
        
        $this->userConnected = $tsi->getToken()->getUser();

        $this->username = $tsi->getToken()->getUserIdentifier();
        $this->name = $this->userConnected->getName() . " " . $this->userConnected->getFirstname();

        $this->recupMonthData($this->reports_reporistory->findBy(['user' => $this->getUsername()]));
        $this->recupYearData($this->reports_reporistory->findBy(['user' => $this->getUsername()]));
    }

    private function recupMonthData(Array $tableau)
    {
        $minutes = 0;
        foreach($tableau as $line)
        {
            if ($line->getDate()->format('m - Y') == $this->today->format('m - Y'))
            {
                $h = $line->getHours()->format('H');
                $m = $line->getHours()->format('i');
                $minutes += $h * 60;
                $minutes += $m;

                $this->publications += $line->getPublications();
                $this->videos += $line->getVideos();
                $this->nv_visites += $line->getNvVisites();
                $this->studies += $line->getStudies();
            }
        }
        $this->hours->i = $minutes % 60;
        $this->hours->h = ($minutes - ($minutes % 60)) / 60;
    }

    private function recupYearData(Array $tableau) 
    {
        $minutesTotales = 0;

        $date = "";
        $min = 0;
        $pub = 0;
        $vid = 0;
        $nv_vis = 0;
        $stud = 0;

        foreach ($tableau as $line)
        {
            if ($line->getDate()->format('Y') == $this->today->format('Y'))
            {
                $h = $line->getHours()->format('H');
                $m = $line->getHours()->format('i');
                $minutesTotales += $h * 60;
                $minutesTotales += $m;

                $min = $h * 60 + $m;
                $date = $line->getDate()->format('Y-m-d');
                $pub = $line->getPublications();
                $vid = $line->getVideos();
                $nv_vis = $line->getNvVisites();
                $stud = $line->getStudies();

                $this->yearData[] = [$date, $min, $pub, $vid, $nv_vis, $stud];
            }
        }

        $this->yearHours->i = $minutesTotales % 60;
        $this->yearHours->h = ($minutesTotales - ($minutesTotales % 60)) / 60;
        dump($this->getYearData());
    }

    //getters et setters

    public function getTwig()
    {
        return $this->twig;
    }

    public function getUsername()
    {
    return $this->username;
    }

    public function getUserConnected()
    {
    return $this->userConnected;
    }

    public function getTodayMonth()
    {
        return $this->todayMonth;
    }

    public function getHours()
    {
        return $this->hours->format('%H:%I');
    }

    public function getYearHours()
    {
        return $this->yearHours->format('%H:%I');
    }

    public function getPublications()
    {
        return $this->publications;
    }

    public function getVideos()
    {
        return $this->videos;
    }

    public function getNvVisites()
    {
        return $this->nv_visites;
    }

    public function getStudies()
    {
        return $this->studies;
    }

    public function getYearData()
    {
        $tabStr = "";
        foreach($this->yearData as $array) {
            $arrayLine = "";
            foreach($array as $element) {
                $elementStr = strval($element);
                $arrayLine .= $elementStr . ";";
            }
            $tabStr .= $arrayLine . "|";
        }
        return $tabStr;
    }

    #[Route('/add', name:'add_report', methods:['GET', 'POST'])]

    public function index():Response
    {
        return new Response($this->twig->render('pages/report.html.twig', [
            'name' => $this->name,
            'month' => $this->getTodayMonth(),
            'hours' => $this->getHours(),
            'publications' => $this->getPublications(),
            'videos' => $this->getVideos(),
            'nv_visites' => $this->getNvVisites(),
            'studies' => $this->getStudies(),
            'year_data' => $this->getYearData()
        ]));
    }
}