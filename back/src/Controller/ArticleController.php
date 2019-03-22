<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\APIService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Persistence\ObjectManager;





class ArticleController extends AbstractController
{
    /**
     * @Route("/article/stats-nationales", name="stats_nationales", methods="GET")
     * ?dateDebut & dateFin = "aaaa-mm-dd"
     */
    public function getStats(Request $request, ObjectManager $objectManager)
    {
        $dateDebut = new \DateTime($request->query->get('dateDebut'));
        $dateFin = new \DateTime($request->query->get('dateFin'));
        $region = $request->query->get('region');
        $annee = $request->query->get('annee');
         $totalSocialScore = 0;
        $arrayToJson = array();
        $nbAccident = 0;
        $nbAccidentVoiture = 0;
        $nbAccidentMoto = 0;
        $nbAccidentAvion = 0;
        $nbAccidentTrain = 0;
        $nbAccidentGrave = 0;
        $nbAccidentVoitureGrave = 0;
        $nbAccidentMotoGrave = 0;
        $nbAccidentTrainGrave = 0;
        $nbAccidentAvionGrave = 0;
        $nbAlcool = 0;

        $flag = true;
        $json_article = $objectManager->getRepository(Article::class)->getStatsByDate($dateDebut, $dateFin);

        if ($annee !== null) {
            $json_article = $objectManager->getRepository(Article::class)->getStatsByYear($annee);
        }

        foreach ($json_article as $article) {
            if ($region !== null) {
                foreach ( $article->getDepartements() as $departement) {
                    if ($departement->getRegion()->getName() === $region) {
                        $flag = true;
                        break;
                    }else {
                        $flag = false;
                    }
                }
            }
            if ($flag) {
                $nbAccident++;
                $totalSocialScore += $article->getSocialScore();
                foreach ($article->getCategories() as $category) {
                    if ($category === "voiture"  or $category === 'fourgon') {
                        $nbAccidentVoiture ++;
                        foreach ($article->getGravite() as $gravite) {
                            if (($gravite === "décès"  or $gravite === 'drame'  or $gravite === 'décédé' or $gravite === 'tué' or $gravite === 'mort') ) {
                                $nbAccidentVoitureGrave++;
                                break;
                            }
                        }
                        break;

                    } else if ($category === "moto" or $category === 'scooter') {
                        $nbAccidentMoto ++;
                        foreach ($article->getGravite() as $gravite) {
                            if (($gravite === "décès"  or $gravite === 'drame'  or $gravite === 'décédé' or $gravite === 'tué' or $gravite === 'mort') ) {
                                $nbAccidentMotoGrave++;
                                break;
                            }
                        }
                        break;

                    } else if ($category === "avion") {
                        $nbAccidentAvion ++;
                        foreach ($article->getGravite() as $gravite) {
                            if (($gravite === "décès"  or $gravite === 'drame'  or $gravite === 'décédé' or $gravite === 'tué' or $gravite === 'mort') ) {
                                $nbAccidentAvionGrave++;
                                break;
                            }
                        }
                        break;

                    } else if ($category === "train") {
                        $nbAccidentTrain++;
                        foreach ($article->getGravite() as $gravite) {
                            if (($gravite === "décès"  or $gravite === 'drame'  or $gravite === 'décédé' or $gravite === 'tué' or $gravite === 'mort') ) {
                                $nbAccidentTrainGrave++;
                                break;
                            }
                        }
                        break;

                    }
                }
                foreach ($article->getGravite() as $gravite) {
                    if (($gravite === "décès"  or $gravite === 'drame'  or $gravite === 'décédé' or $gravite === 'tué' or $gravite === 'mort') ) {
                        $nbAccidentGrave++;
                        break;
                    }
                }
                if (count($article->getCauses()) > 0 ) {
                    $nbAlcool ++;
                }
            }
        }

        if ($nbAccident === 0) {
             return JsonResponse::fromJsonString(  json_encode("not found"));

        }
         $moySocialScore = ($totalSocialScore/$nbAccident);

        $arrayToJson += ['moyenne_social_score' => $moySocialScore];
        $arrayToJson += ['nombre_accident' => $nbAccident];
        $arrayToJson += ['nombre_accident_grave' => $nbAccidentGrave];
        $arrayToJson += ['voiture' => $nbAccidentVoiture];
        $arrayToJson += ['voitureGrave' => $nbAccidentVoitureGrave];
        $arrayToJson += ['moto' => $nbAccidentMoto];
        $arrayToJson += ['motoGrave' => $nbAccidentMotoGrave];
        $arrayToJson += ['train' => $nbAccidentTrain];
        $arrayToJson += ['trainGrave' => $nbAccidentTrainGrave];
        $arrayToJson += ['avion' => $nbAccidentAvion];
        $arrayToJson += ['avionGrave' => $nbAccidentAvionGrave];
        $arrayToJson += ['alcool' => $nbAlcool];


        $json_article = json_encode($arrayToJson);

        return JsonResponse::fromJsonString($json_article);
    }

    /**
     * @Route("/article/stats-months", name="stats_months", methods="GET")
     * ?dateDebut & dateFin = "aaaa-mm-dd"
     */
    public function getStatsByMonth(Request $request, ObjectManager $objectManager)
    {

        $dateDebut = new \DateTime($request->query->get('dateDebut'));
        $dateFin = new \DateTime($request->query->get('dateFin'));


        $dateInterval = $dateFin->diff($dateDebut);

        $totalMonths = 12 * $dateInterval->y + $dateInterval->m;

        $arrayToJson = array();

        while ($totalMonths >= 0) {
            $dateFin->format('Y');
            $totalSocialScore = 0;
            $nbAccident = 0;
            $nbAccidentVoiture = 0;
            $nbAccidentMoto = 0;
            $nbAccidentAvion = 0;
            $nbAccidentTrain = 0;

            $json_article = $objectManager->getRepository(Article::class)->getStatsByYearMonth( $dateFin->format('Y'), $dateFin->format('m'));

            foreach ($json_article as $article) {
                $nbAccident++;
                $totalSocialScore += $article->getSocialScore();
                foreach ($article->getCategories() as $category) {
                    if ($category === "voiture"  or $category === 'fourgon') {
                        $nbAccidentVoiture ++;
                    } else if ($category === "moto" or $category === 'scooter') {
                        $nbAccidentMoto ++;
                    } else if ($category === "avion") {
                        $nbAccidentAvion ++;
                    } else if ($category === "train") {
                        $nbAccidentTrain++;
                    }
                }

            }
            $moySocialScore = ($totalSocialScore/$nbAccident);

             $monthNames = ["Janvier", "Février", "Mars", "Avril", "mai", "Juin",
                "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"
            ];
            array_push($arrayToJson,[
                'mois' =>  $monthNames[(int)$dateFin->format('m') - 1],
                "moyenne_social_score" => $moySocialScore,
                "nombre_accident" => $nbAccident,
                "voiture" => $nbAccidentVoiture,
                "moto" => $nbAccidentMoto,
                "train" => $nbAccidentTrain,
                "avion" => $nbAccidentAvion
            ])


            ;

            $dateFin->modify('-1 month');
            $totalMonths--;
        }
        $json_article = json_encode(array_reverse($arrayToJson));

        return JsonResponse::fromJsonString($json_article);
    }
}