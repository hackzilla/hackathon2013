<?php

namespace Hackzilla\HackathonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SmsController extends Controller
{
    public function failAction()
    {
        $response = new Twilio\Utility\Twiml();
        $response->say('Sorry, we appear to be having difficulties.  Please try again later.');
        
        print $response;
        die;
    }
    
    public function statusAction()
    {
        $response = new Twilio\Utility\Twiml();
        $response->say('Sorry, I don\'t know what you want.');
        
        print $response;
        die;
    }

    public function indexAction()
    {
        return $this->render('HackzillaHackathonBundle:Sms:index.html.twig', array(
        ));
    }
}
