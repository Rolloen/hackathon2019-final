<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\APIService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class OzaeController extends AbstractController
{
    /**
     * @Route("/api/ozae/", name="_ozae", methods="GET")
     */
    public function getAccident(APIService $APIService)
    {
        $data = $APIService->CallAPI('GET', 'https://api.ozae.com/gnw/articles?date=20180701__20180702&edition=fr-fr&key=f287095e988e47c0804e92fd513b9843&hard_limit=50&topic=b&order[col]=social_score');

        return $data;
    }

    /**
     * @Route("/api/ozae/articlesbykeyword", name="_ozaeByKeyword", methods="GET")
     */
    public function getArticlesByKeyword(Request $request, APIService $APIService)
    {
//        echo $request->query->get('keyword');die;
        $keyword = $request->query->get('keyword');
        $date = $request->query->get('date');


        $data = $APIService->CallAPI('GET', 'https://api.ozae.com/gnw/articles?date='.$date.'&key=f287095e988e47c0804e92fd513b9843&edition=fr-fr&query='.$keyword.'');

        return $data;
    }
}