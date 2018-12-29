<?php
namespace App\Service;

class SmtpTransport {
    
    private const HOST = 'smtp.franceserv.fr';
    private const USERNAME = 'libertalia';
    private const PASSWORD = '1491Js93@655957';
    private const PORT = 25;
    
    /**
     * 
     * @return Swift_SmtpTransport
     */
    public function getSwiftTransport() : \Swift_SmtpTransport {
        return (new \Swift_SmtpTransport(self::HOST, self::PORT))
                ->setUsername(self::USERNAME)
                ->setPassword(self::PASSWORD);
    }
}