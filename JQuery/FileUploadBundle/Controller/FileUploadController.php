<?php

namespace JQuery\FileUploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


use JQuery\FileUploadBundle\Classes\UploadHandler;


class FileUploadController extends Controller
{

    /**
     * Render the page
     */
    public function indexAction()
    {
        return $this->render('JQueryFileUploadBundle::index.html.twig');
    }



    public function addAction() {
        // Get the response
        $request = $this->get('request');

        // Init the Upload Handler, see Classes/UploadHandler.php for options
        // The second paramter is needed for Symfony to know where to redirect the answer
        $upload_handler = new UploadHandler(null, $this->generateUrl('jquery_fileupload_add'));

        // Switch action, do the method
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

        // Call the Response and add Headers needed 
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