<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 18/02/18
 * Time: 17:17
 */

namespace App\Controller;


use App\Form\LoginType;
use App\Model\User;
use App\Repository\UserRepository;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AppController
{


    /**
     * @param ServerRequestInterface $request
     * @return \GuzzleHttp\Psr7\Response|mixed
     */
    public function login(ServerRequestInterface $request)
    {

        if (!$this->getUser()) {

            $loginType = new LoginType();
            $form = $loginType->buildForm();

            if ($request->getMethod() == 'POST') {

                $form->validate($request->getParsedBody());
                if ($form->isValid()) {

                    $mail = $form->getData()['mail'];
                    $password = $form->getData()['password'];

                    /**
                     * @var User $user
                     */
                    $user = (new UserRepository())->findBy(['username' => $mail], true);

                    if ($user && $this->passwordValid($password, $user->getPassword())) {
                        $this->generateSession($user);

                        if ($this->isGranted('ROLE_ADMIN')) {

                            return $this->redirectTo('/admin');

                        }
                        return $this->redirectTo('/');
                    }

                }
            }

            return $this->render('security/login.html.twig', ['form' => $form]);

        }

       return $this->redirectTo('/');
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        if ($this->getUser()) {

            $this->removeSession();
        }
       return $this->redirectTo('/');
    }

}