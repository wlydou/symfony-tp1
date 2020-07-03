<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MultiplicationController extends AbstractController
{
    /**
     * @Route("/multiplication", name="multiplication")
     */
    public function index(SessionInterface $session)
    {
        //Récupération des valeurs dans la session
        $xmin = $session->get('xmin-multiplication');
        $xmax = $session->get('xmax-multiplication');
        $ymin = $session->get('ymin-multiplication');
        $ymax = $session->get('ymax-multiplication');

        //Si les valeurs session n'existent pas, on renvoie des valeurs par défaut (0-10)
        if(empty($xmin) || empty($xmax) || empty($ymin) || empty($ymax)){
            return $this->render('multiplication/index.html.twig', [
                'controller_name' => 'MultiplicationController',
                'inputs' => [0, 10, 0, 10]
            ]);
        } else {
            //Valeurs session existantes
            return $this->render('multiplication/index.html.twig', [
                'controller_name' => 'MultiplicationController',
                'inputs' => [$xmin, $xmax, $ymin, $ymax]
            ]);
        }
    }

     /**
     * @Route("/multiplication/{xmin}/{xmax}/{ymin}/{ymax}", name="multiplicationAction")
     */
    public function multiplicationAction($xmin, $xmax, $ymin, $ymax, SessionInterface $session)
    {
        //Vérification des entiers
        if(is_int($xmin) || is_int($xmax) || is_int($ymin) || is_int($ymax)) {
            throw new \Exception('Les valeurs ne sont pas bonnes');
        }

        //Vérification des valeurs positives
        if($xmin <= 0 || $xmax <= 0 || $ymin <= 0 || $ymax <= 0) {
            throw new \Exception('Les valeurs ne sont pas des entiers positifs');
        }

        //Enregistrement des valeurs dans la session
        $session->set('xmin-multiplication', $xmin);
        $session->set('xmax-multiplication', $xmax);
        $session->set('ymin-multiplication', $ymin);
        $session->set('ymax-multiplication', $ymax);

        return $this->render('multiplication/index.html.twig', [
            'controller_name' => 'MultiplicationController',
            'inputs' => [$xmin, $xmax, $ymin, $ymax]
        ]);
    }

    /**
     * @Route("/addLineMultiply", name="addLineMultiply")
     */
    public function addLineMultiply(Request $request, SessionInterface $session)
    {   
        $inputs =  $request->query->get('inputs');

        //Ajout d'une ligne (ymax + 1)
        $inputs[3] += 1;

        //Mise à jour variable session ymax
        $session->set('ymax-multiplication', $inputs[3]);

        return $this->render('multiplication/index.html.twig', [
            'controller_name' => 'MultiplicationController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/addColumnMultiply", name="addColumnMultiply")
     */
    public function addColumnMultiply(Request $request, SessionInterface $session)
    {   
        $inputs =  $request->query->get('inputs');

        //Ajout d'une colonne (xmax + 1)
        $inputs[1] += 1;

        //Mise à jour variable session xmax
        $session->set('xmax-multiplication', $inputs[1]);

        return $this->render('multiplication/index.html.twig', [
            'controller_name' => 'MultiplicationController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/removeLineMultiply", name="removeLineMultiply")
     */
    public function removeLineMultiply(Request $request, SessionInterface $session)
    {   
        $inputs =  $request->query->get('inputs');

        //Suppression d'une ligne (ymax - 1)
        $inputs[3] -= 1;

        //Mise à jour variable session ymax
        $session->set('ymax-multiplication', $inputs[3]);

        return $this->render('multiplication/index.html.twig', [
            'controller_name' => 'MultiplicationController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/removeColumnMultiply", name="removeColumnMultiply")
     */
    public function removeColumnMultiply(Request $request, SessionInterface $session)
    {   
        $inputs =  $request->query->get('inputs');

        //Suppression d'une colonne (xmax - 1)
        $inputs[1] -= 1;

        //Mise à jour variable session xmax
        $session->set('xmax-multiplication', $inputs[1]);

        return $this->render('multiplication/index.html.twig', [
            'controller_name' => 'MultiplicationController',
            'inputs' => $inputs
        ]);
    }
}
