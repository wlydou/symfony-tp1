<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => [$xmin, $xmax, $ymin, $ymax]
        ]);
    }

    /**
     * @Route("/addLine", name="addLine")
     */
    public function addLine(Request $request)
    {   
        $inputs =  $request->query->get('inputs');

        //Ajout d'une ligne (ymax + 1)
        $inputs[3] += 1;

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/addColumn", name="addColumn")
     */
    public function addColumn(Request $request)
    {   
        $inputs =  $request->query->get('inputs');

        //Ajout d'une colonne (xmax + 1)
        $inputs[1] += 1;

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/removeLine", name="removeLine")
     */
    public function removeLine(Request $request)
    {   
        $inputs =  $request->query->get('inputs');

        //Suppression d'une ligne (ymax - 1)
        $inputs[3] -= 1;

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/removeColumn", name="removeColumn")
     */
    public function removeColumn(Request $request)
    {   
        $inputs =  $request->query->get('inputs');

        //Suppression d'une colonne (xmax - 1)
        $inputs[1] -= 1;

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => $inputs
        ]);
    }
}
