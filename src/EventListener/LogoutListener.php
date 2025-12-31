<?php namespace App\EventListener;

class LogoutListener
{
    public function onSymfonyComponentSecurityHttpEventLogoutEvent(): void
    {
        if(isset($_COOKIE['BEARER'])) {
            setcookie('BEARER', "", ['expires' => time()-(60*60*24*7), 'path' => '/']);
        }
    }
}
