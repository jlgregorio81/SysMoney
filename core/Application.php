<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core;

use app\view\home\Home;


/**
 * Description of Application
 *
 * @author jlgre_000
 */
class Application
{

    const APP_NAME = 'SysMoney';
        
    //..ícone da aplicação.
    const APP_ICON = 'core/img/sysmoney.png';

    const ICON_NEW = 'core/img/new.png';
    const ICON_SAVE = 'core/img/save.png';
    const ICON_DELETE = 'core/img/delete.png';
    const ICON_SEARCH = 'core/img/search.png';
    const ICON_SUCCESS = 'core/img/success.png';
    const ICON_ERROR = 'core/img/error.png';
    const ICON_WARNING = 'core/img/warning.png';
    const ICON_NOT_FOUND = 'core/img/notfound.png';
    const ICON_EXIT = 'core/img/exit.png';
    const ICON_OPEN = 'core/img/open.png';
    const ICON_CHECKED = 'core/img/checked.png';
    const ICON_LOADING = 'core/img/loading.png';


    const MSG_TITLE_DEFAULT = 'Informação do Sistema';

    const MSG_SUCCESS = 'Operação realizada com sucesso!';
    const MSG_ERROR = 'Erro durante a operação...';
    const MSG_NOT_FOUND = 'Objeto não encontrado.';
    
     
    //..config de email.
    const EMAIL = 'jorge.gregorio@fatec.sp.gov.br'; //..email usado para enviar as msgs
    const EMAIL_NAME = 'SysMoney 2018'; //..nome que aparecerá ao destinatário
    const EMAIL_PASSWD = 'SUA SENHA AQUI!'; //..senha do e-mail



    /**
     * Inicia a aplicação - página inicial
     */
    public static function start()
    {
        (new Home())->show();
    }

    public static function sendEmail($emailDest, $subject, $msg)
    {
        //..faz a requisição do autoload da classe PHPMailer.
        require_once 'core/vendor/php-mailer/PHPMailerAutoLoad.php';        
        //..instanciar a classe PHPMailer        
        $email = new \PHPMailer(true);
        $email->CharSet = 'utf-8';
        //..configurar atributos de acordo com o servidor do e-mail
        //..aqui está de acordo com o e-mail institucional da FATEC.
        //..caso use gmail para enviar, além da configuração, será necessário permitir acesso de aplicativos de terceiros (menos seguros) na configuração da sua conta
        $email->isSMTP();
        $email->SMTPAuth = true;
        $email->SMTPSecure = 'tls';
        $email->Port = 587;
        $email->Host = 'smtp.office365.com';
        //..definir o e-mail e o nome de origem
        $email->From = self::EMAIL; //..opcional - pegando da constante EMAIL desta própria classe
        $email->FromName = self::EMAIL_NAME; //..opcional
        $email->Username = self::EMAIL; //..nome do e-mail
        $email->Password = self::EMAIL_PASSWD; //..senha do email
        //..definir o e-mail do destinatário
        $email->addAddress($emailDest);
        //..adiciona o assunto
        $email->Subject = $subject;
        //..adiciona a msg
        $email->msgHTML($msg);
        //..se não conseguir enviar, lança uma exceção
        if (!$email->send()) {
            throw new \Exception("Erro ao enviar e-mail:" .
                $email->ErrorInfo);
        }
    }

    public static function getRootPath()
    {
        $rootPath = $_SERVER['DOCUMENT_ROOT'] . 'SysMoney2018/' ;        
        return $rootPath;
    }

    /**
     * Retorna o caminho da pasta tmp da aplicação: se true retorna o caminho completo do server; se false retorna o caminho válido no cliente, ou seja, apenas a partir do root. 
     * @param boolean $server determina o tipo de caminho que será retornado
     */
    public static function getTmpPath($server = true){
        $tmpPath = self::getRootPath() . "app/tmp/";
        if ($server)
            return $tmpPath;
        else
            return "app/tmp/";
    }

}