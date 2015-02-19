<?php

namespace SB\FormulaireBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SB\FormulaireBundle\Entity\DVD;

class FormulaireController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SBFormulaireBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function ajoutFormAction(Request $request)
    {
        $dvd = new DVD();
        $dvd->setTitre('Ghost Rider')
            ->setAuteur('Nicola CAGE')
            ->setPrix(10);
        
        $formBuilder = $this->get('form.factory')->createBuilder('form', $dvd);
        
        $formBuilder->add('titre','text')
                    ->add('auteur','text')
                    ->add('prix','text')
                    ->add('sauver','submit');
        
        $form = $formBuilder->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {       
            $em = $this->getDoctrine()->getManager();
        
            // Étape 1 : On « persiste » l'entité
            $em->persist($dvd);

            // Étape 2 : On « flush » tout ce qui a été persisté avant
            $em->flush();

            // Reste de la méthode qu'on avait déjà écrit
            if ($request->isMethod('POST')) {
                $request->getSession()->getFlashBag()->add('notice', 'Le DVD a bien été enregistré.');
                
                // On redirige vers la page de visualisation du DVD nouvellement créé
                return $this->render('SBFormulaireBundle:Formulaire:dvd', array('id' => $dvd->getId()));
            }
        }
        
        return $this->render('SBFormulaireBundle:Formulaire:formulaire.html.twig', array(
      'form' => $form->createView(),
    ));
        
    }
}
