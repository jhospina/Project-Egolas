<?php

namespace App\System\Library\Com;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class Email {

    const VAR_HEADER = "header";
    const VAR_NAME = "name";
    const VAR_DESCRIPTION = "description";
    const VAR_EMAIL = "email";
    const EMAIL_FROM = "bandicot.info@gmail.com";

    var $header;
    var $name;
    var $description;
    var $email;
    var $subject;
    var $template;

    /** Inicializa los datos del correo electronico que se va ha enviar
     * 
     * @param type $subject // Asunto
     * @param type $email // Correo electronico
     * @param type $data //Datos del contenido
     * @param type $template //Plantilla del correo
     */
    function __construct($subject, $email, $data = null, $template = "basic") {
        $this->setSubject($subject);
        $this->setEmail($email);

        $this->setHeader(isset($data[Email::VAR_HEADER]) ? $data[Email::VAR_HEADER] : $subject);
        $this->setName(isset($data[Email::VAR_NAME]) ? $data[Email::VAR_NAME] : null);
        $this->setDescription(isset($data[Email::VAR_DESCRIPTION]) ? $data[Email::VAR_DESCRIPTION] : null);
        $this->setTemplate($template);
    }

    /** Envia el correo
     * 
     * @return boolean
     */
    function send() {

        $data = $this->getData();

        return Mail::send('emails.' . $this->getTemplate(), $data, function($message) {
                    $message->to($this->getEmail())->subject($this->getSubject());
                });
    }

    /** Pone en cola el correo para enviar
     * 
     * @return type
     */
    function queue() {
        $data = $this->getData();
        return Mail::queue('emails.' . $this->getTemplate(), $data, function($message) {
                    $message->to($this->getEmail())->subject($this->getSubject());
                });
    }

    private function getData() {
        return [
            self::VAR_HEADER => $this->getHeader(),
            self::VAR_NAME => $this->getName(),
            self::VAR_DESCRIPTION => $this->getDescription(),
            self::VAR_EMAIL => $this->getEmail()
        ];
    }

    function getHeader() {
        return $this->header;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getEmail() {
        return $this->email;
    }

    function getSubject() {
        return $this->subject;
    }

    function getTemplate() {
        return $this->template;
    }

    function setTemplate($template) {
        $this->template = $template;
    }

    function setHeader($header) {
        $this->header = $header;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

}
