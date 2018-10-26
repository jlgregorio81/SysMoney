<?php
namespace app\controller;

use core\mvc\Controller;
use app\view\user\UserView;
use app\dao\UserDao;
use app\model\UserModel;
use app\model\CityModel;
use app\dao\CityDao;
use app\view\user\UserList;

use core\mvc\view\Message;
use core\Application;
use core\util\Session;
use app\view\home\Home;
use core\dao\SqlObject;
use core\dao\Connection;


//..incluir a view de listagem.

final class UserCtr extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->model = new UserModel();
        $this->dao = new UserDao();
        $this->view = new UserView();
        $this->viewList = new UserList();
    }

    public function viewToModel()
    {
        if ($this->post) {
            $this->model->setId($this->post['id']);
            $this->model->setName($this->post['name']);
            $this->model->setGender($this->post['gender']);
            $this->model->setEmail($this->post['email']);
            $this->model->setCity(new CityModel($this->post['city']));
            $this->model->setPassword($this->post['password']);
            $this->model->setType('U');
            $this->model->setStatus('I');
        }
    }

    public function showView()
    {
        //..busca todas as cidades cadastradas.
        $cities = (new CityDao())->selectAll();
        //..seta as cidades na view para que possam ser exibidas
        $this->view->setCities($cities);
        //..invoca o método pai
        parent::showView();
    }

    public function showList()
    {
        if ($this->post) {
            $this->criteria = "upper (" . UserDao::COL_NAME . ") like upper('{$this->post['data'][0]}')  
             and " . UserDao::COL_STATUS . " = '{$this->post['data'][1]}'";
            $this->orderBy = UserDao::COL_NAME;
        }
        parent::showList();
    }

    /**  
     * Cria uma sessão e armazena um objeto User model.
     * @return void
     */
    public function doLogin()
    {
        //..se houver no get uma variável nomeada method, então...
        if (isset($this->get['method'])) {
            $email = $this->post['email']; //..pega os dados do form
            $passwd = $this->post['passwd'];
            //..faz a busca de usuário baseado no e-mail e senha
            $activeUser = (new UserDao())->findForLogin($email, $passwd);
            if ($activeUser) { //..se encontrou, então...
                //..armazena o objeto model na sessão 'activeUser'
                Session::createSession('activeUser', $activeUser);
                //..vai para a página inicial
                (new Home())->show();
            } else {
            //..vai para a página inicial com msg de erro
                (new Home('Dados incorretos! Tente novamente.'))->show();
            }
        }
    }

    /**
     * Destrói a sessão 'activeUser', fazendo logout.
     * @return void
     */
    public function doLogout()
    {
        Session::destroySession('activeUser');
        Application::start();
    }

    /**
     * Insere um usuário e envia e-mail para que o cadastro seja validado. Note que esse método não precisaria ser implementado caso não tivesse que enviar o e-mail, pois ele é herdado da superclasse.
     * 
     */
    public function insertUpdate()
    {
        try {
            //..alimenta o model com os dados da View
            $this->viewToModel();
            //..seta o modelo atualizado no objeto DAO            
            $this->dao->setModel($this->model);
            //..invoca o método insertUpdate para persistir o Model - pega o id inserido
            $this->dao->insertUpdate();
            //..cria uma view com mensagem de sucesso.
            $msg = new Message(
                Application::MSG_TITLE_DEFAULT,
                Application::MSG_SUCCESS,
                Application::ICON_SUCCESS
            );
            //..cria o link para ativação do usuário
            $link = "http://localhost/SysMoney2018/Request.php?class=UserCtr&method=activateUser&userEmail={$this->model->getEmail()}";
            //..envia e-mail.
            $txt = "<h1>SysMoney</h1>";
            $txt .= "<p>Recebemos o seu cadastro! Clique no link abaixo para ativá-lo!</p>";
            $txt .= "<a href=\"$link\" target=\"_blank\">Clique Aqui!</a>";
            //..envia o email usando o método estática sendEmail da classe Application
            Application::sendEmail(
                $this->model->getEmail(),
                Application::APP_NAME . " - Ativação (não responda)",
                $txt
            );
        } catch (Exception $ex) {
            $msg = new Message(
                Application::MSG_TITLE_DEFAULT,
                Application::MSG_ERROR,
                Application::ICON_ERROR
            );
        }
        finally {
            $msg->show();
        }
    }

    /**
     * Método para ativar o usuário - ativado pel o link enviado ao e-mail do usuário
     */
    public function activateUser()
    {
        $msg = null;
        try {
            $email = $this->get['userEmail']; //..pega o email
            $sqlObj = new SqlObject(Connection::getConnection()); //..cria um SqlObject
            //..executa uma atualização = update users set status_user = 'A'where email_user = $email 
            $sqlObj->update('users', array('status_user' => 'A'), "email_user = '{$email}' ");
            //.. cria uma página para msg de sucesso
            $msg = new Message(Application::MSG_TITLE_DEFAULT, 'Usuário ativado com sucesso! Faça o login!', null);
        } catch (\Exception $ex) {
            //..se der erro, cria uma página para msg de erro
            $msg = new Message(Application::MSG_TITLE_DEFAULT, Application::MSG_ERROR, null);
        } finally{ //..mostra a msg
            $msg->show();
        }


    }


} 