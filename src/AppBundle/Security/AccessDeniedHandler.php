<?php
/**
 * Created by PhpStorm.
 * User: Aloui Omar
 * Date: 03/21/2020
 * Time: 14:51
 */

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler extends Controller implements AccessDeniedHandlerInterface
{

    /**
     * Handles an access denied failure.
     *
     * @return Response|null
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {

        // TODO: Implement handle() method.
        return $this->redirect("404");
    }
}



//return new Response('<h1>Accès non autorisé</h1>');
