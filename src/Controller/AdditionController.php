<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdditionController extends AbstractController
{
    /**
     * @Route("/addition", name="addition")
     */
    public function index(SessionInterface $session)
    {
        //Récupération des valeurs dans la session
        $xmin = $session->get('xmin');
        $xmax = $session->get('xmax');
        $ymin = $session->get('ymin');
        $ymax = $session->get('ymax');

        //Si les valeurs session n'existent pas, on renvoie des valeurs par défaut (0-10)
        if(empty($xmin) || empty($xmax) || empty($ymin) || empty($ymax)){
            return $this->render('addition/index.html.twig', [
                'controller_name' => 'AdditionController',
                'inputs' => [0, 10, 0, 10]
            ]);
        } else {
            //Valeurs session existantes
            return $this->render('addition/index.html.twig', [
                'controller_name' => 'AdditionController',
                'inputs' => [$xmin, $xmax, $ymin, $ymax]
            ]);
        }
    }

     /**
     * @Route("/addition/{xmin}/{xmax}/{ymin}/{ymax} ", name="additionAction")
     */
    public function additionAction($xmin, $xmax, $ymin, $ymax, SessionInterface $session)
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
        $session->set('xmin', $xmin);
        $session->set('xmax', $xmax);
        $session->set('ymin', $ymin);
        $session->set('ymax', $ymax);

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => [$xmin, $xmax, $ymin, $ymax]
        ]);
    }

    /**
     * @Route("/addLine", name="addLine")
     */
    public function addLine(Request $request, SessionInterface $session)
    {   
        $inputs =  $request->query->get('inputs');

        //Ajout d'une ligne (ymax + 1)
        $inputs[3] += 1;

        //Mise à jour variable session ymax
        $session->set('ymax', $inputs[3]);

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/addColumn", name="addColumn")
     */
    public function addColumn(Request $request, SessionInterface $session)
    {   
        $inputs =  $request->query->get('inputs');

        //Ajout d'une colonne (xmax + 1)
        $inputs[1] += 1;

        //Mise à jour variable session xmax
        $session->set('xmax', $inputs[1]);

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/removeLine", name="removeLine")
     */
    public function removeLine(Request $request, SessionInterface $session)
    {   
        $inputs =  $request->query->get('inputs');

        //Suppression d'une ligne (ymax - 1)
        $inputs[3] -= 1;

        //Mise à jour variable session ymax
        $session->set('ymax', $inputs[3]);

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => $inputs
        ]);
    }

    /**
     * @Route("/removeColumn", name="removeColumn")
     */
    public function removeColumn(Request $request, SessionInterface $session)
    {   
        $inputs =  $request->query->get('inputs');

        //Suppression d'une colonne (xmax - 1)
        $inputs[1] -= 1;

        //Mise à jour variable session xmax
        $session->set('xmax', $inputs[1]);

        return $this->render('addition/index.html.twig', [
            'controller_name' => 'AdditionController',
            'inputs' => $inputs
        ]);
    }
}
