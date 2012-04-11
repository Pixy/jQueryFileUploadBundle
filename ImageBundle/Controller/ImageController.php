<?php

namespace Bold\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


use Bold\ImageBundle\Classes\UploadHandler;


class ImageController extends Controller
{

    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if(!$projet = $em->getRepository('BoldPrezBundle:Projet')->find($id)) {
            throw $this->createNotFoundException('Le projet[id='.$id.'] n\'existe pas.');
        }
        $client = $projet->getClient();
        $projets = $client->getProjets();

        return $this->render('BoldImageBundle::index.html.twig', array(
            'client' => $client,
            'projet' => $projet,
            'projets' => $projets,
        ));
    }


    /**
     *  Ajouter une image
     * @param integer $id
     */
    public function ajouterAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        if(!$projet = $em->getRepository('BoldPrezBundle:Projet')->find($id)) {
            throw $this->createNotFoundException('Le projet[id='.$id.'] n\'existe pas.');
        }
        $client = $projet->getClient();
        $request = $this->get('request');

        $upload_handler = new UploadHandler(null, $this->generateUrl('bold_image_ajax_ajouter', array('id' => $id)));


        switch ($request->getMethod()) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $upload_handler->get();
                break;
            case 'POST':
                if ($request->get('_method') === 'DELETE') {
                    $upload_handler->delete();
                } else {
                    $upload_handler->post();
                }
                break;
            case 'DELETE':
                $upload_handler->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }

        $response = new Response();
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate');
        $response->headers->set('Content-Disposition', 'inline; filename="files.json"');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'OPTIONS, HEAD, GET, POST, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'X-File-Name, X-File-Type, X-File-Size');
        return $response;
    }
}