<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdditionController extends AbstractController
{
    /**
     * @Route("/addition", name="addition")
     */
    public function index()
    {
        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
        ]);
    }

     /**
     * @Route("/addition/{xmin}/{xmax}/{ymin}/{ymax} ", name="additionAction")
     */
    public function additionAction($xmin, $xmax, $ymin, $ymax)
    {
        //Vérification des entiers
        if(is_int($xmin) || is_int($xmax) || is_int($ymin) || is_int($ymax)) {
            throw new \Exception('Les valeurs ne sont pas bonnes');
        }

        //Vérification des valeurs positives
        if($xmin <= 0 || $xmax <= 0 || $ymin <= 0 || $ymax <= 0) {
            throw new \Exception('Les valeurs ne sont pas des entiers positifs');
        }

        $result = [];
        $valuesY = [];

        //Algorithme de calcul
        for($i = $xmin; $i <= $xmax; $i++) { //Parcours des x
            for($j = $ymin; $j <= $ymax; $j++) {//Parcours des y
                $somme = $i + $j;
                array_push($result, $somme);
            }
        }

        for($k = $ymin; $k <= $ymax; $k++) {
            array_push($valuesY, $k);
        }

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => [$xmin, $xmax, $ymin, $ymax],
            'result' => $result,
            'rows' => $valuesY
        ]);
    }
}
