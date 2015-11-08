<?php
namespace OkulBilisim\AdvancedCitationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @param string $name
     * @return Response
     */
    public function indexAction($name)
    {
        return $this->render(
            'AdvancedCitationBundle:Default:index.html.twig',
            array(
                'name' => $name
            )
        );
    }
}
