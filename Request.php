<?php

use core\util\Session;
use core\Application;

/**
 * Classe que concentra todas as requisições - PageController
 */
class Request
{
    /**
     * Trata uma requisição de um cliente. 
     */
    static function getRequest()
    {
        //..se existir alguma coisa no $_GET, então...
        if ($_GET) {            
            //..pega a classe (se existir)
            $class = isset($_GET['class']) ? $_GET['class'] : null;
            //..pega o método (se existir)
            $method = isset($_GET['method']) ? $_GET['method'] : null;

            /**
             * REGRAS PARA QUE A REQUISIÇÃO SEJA FEITA:
             * Tem que haver uma sessão chamada activeUser ou
             * o método chamado é doLogin (usuário tentando fazer login) ou
             * a classe é igual a UserCtr e (método é igual a showView ou run) (usuário tenando se cadastrar) ou
             * o método é igual a activateUser (usuário tentando ativar cadastro)
             * Se o resultado do 'if' for falso, não faz a requisição. 
             */

            if (Session::getSession('activeUser') || $method == 'doLogin' 
                || ($class == 'UserCtr' && ($method == 'showView' || $method == 'run'))
                || $method == 'activateUser'   
            ) {
                if ($class) {
                    $class = "app\\controller\\" . $class; //..acerta o caminho da classe.
                    //..instancia um novo objeto da classe informada.
                    $object = new $class;
                    //..se o método existir no objeto, então...
                    if (method_exists($object, $method)) {
                        //..invoca o método.
                        call_user_func(array($object, $method));
                    }
                } else if (function_exists($method)) {
                    call_user_func($method, $GET);
                }
            } else {
                Application::start();
            }
        }
    }
}


//..inclui o autoload
require_once 'autoload.php';
//..trata a requisição
Request::getRequest();




