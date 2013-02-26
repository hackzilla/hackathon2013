<?php

namespace Hackzilla\HackathonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Twilio;
use Twilio\Utility;

use Hackzilla\HackathonBundle\Entity\CallBack;
use Hackzilla\HackathonBundle\Entity\CallLog;

class VoiceController extends Controller
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
        $url = $this->get('router')->generate(
            'prompt_stage_2'
        );
   
        $response = new Twilio\Utility\Twiml();
        $response->say('Hello.');
        $response->say('If you have a pin number, please enter it now followed by the star key.');
        $response->gather(array(
            'action'  => $url,
            'method'  => 'GET',
            'timeout' => '10',
            'numDigits' => '3',
            'finishOnKey' => "*",
        ));
        
        print $response;
        die;
    }
    
    public function stage2Action()
    {
        $pin = $this->getRequest()->query->get('Digits', -1);

        $url = $this->get('router')->generate(
            'prompt_stage_3',
            array(
                'pin' => $pin,
            )
        );

        $response = new Twilio\Utility\Twiml();
        $response->say('Thank you.');
        $response->say('Please press 1 to talk to a real person, or press 2 to leave a message.');
        $response->gather(array(
            'action'  => $url,
            'method'  => 'GET',
            'timeout' => '5',
            'finishOnKey' => "*",
            'numDigits'   => '1',
        ));
        
        print $response;
        die;
    }

    public function stage3Action($pin)
    {
        $action = $this->getRequest()->query->get('Digits', 1);
        $response = new Twilio\Utility\Twiml();
        
        if($action == 2) {
            $url = $this->get('router')->generate(
                'prompt_stage_4',
                array(
                    'pin' => $pin,
                )
            );

            // answer phone
            $response->say('Transfering you to an answer phone, please leave your message after the beep.');
            $response->record(array(
                'action' => $url,
                'method' => 'GET',
                'transcribe' => true,
                'transcribeCallback' => '',
                'playBeep' => true,
            ));
        } else {
            $helpdeskNumber = $this->container->getParameter('twilio.helpdesk');
            // real person
            $response->say('Transfering you to a real person.');
            
            if(0) {
                $response->dial($helpdeskNumber, array(

                ));
            } else {
                $response->say('This concludes the demo.');
            }

            $from = $this->getRequest()->query->get('From');
            $sid = $this->getRequest()->query->get('CallSid');
            $state = $this->getRequest()->query->get('CalledState');
            $country = $this->getRequest()->query->get('CalledCountry');

            $calllog = new CallLog();
            $calllog->setPin($pin);
            $calllog->setFrom($from);
            $calllog->setCallSid($sid);
            $calllog->setState($state);
            $calllog->setCountry($country);

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($calllog);
            $em->flush();
        }

        print $response;
        die;
    }

    public function stageHelpdeskAction($pin)
    {
        $from = $this->getRequest()->query->get('From');
        $sid = $this->getRequest()->query->get('CallSid');
        $state = $this->getRequest()->query->get('CalledState');
        $country = $this->getRequest()->query->get('CalledCountry');

        // save
        $calllog = new CallLog();
        $calllog->setPin($pin);
        $calllog->setFrom($from);
        $calllog->setCallSid($sid);
        $calllog->setState($state);
        $calllog->setCountry($country);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($calllog);
        $em->flush();

        $response = new Twilio\Utility\Twiml();
      
        print $response;
        die;
    }
    
    /*
     * Recordings%2FRE3eaae87739332bce38ab3bd683cea44d&
     * RecordingDuration=6&
     */
    
    public function stageTranscribeAction($pin)
    {
        $from = $this->getRequest()->query->get('From');
        $sid = $this->getRequest()->query->get('CallSid');
        $state = $this->getRequest()->query->get('CalledState');
        $country = $this->getRequest()->query->get('CalledCountry');
        $recordings = $this->getRequest()->query->get('RecordingUrl');
        $recordingDuration = $this->getRequest()->query->get('RecordingDuration');

        // save
        $callback = new CallBack();
        $callback->setPin($pin);
        $callback->setFrom($from);
        $callback->setCallSid($sid);
        $callback->setState($state);
        $callback->setCountry($country);
        $callback->setRecording($recordings);
        $callback->setRecordingDuration($recordingDuration);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($callback);
        $em->flush();
        
        $response = new Twilio\Utility\Twiml();
        
        // answer phone
        $response->say('Thank-you.  You will recieve a callback soon.');

        print $response;
        die;
    }
    
    public function numbersAction()
    {
        $sid = $this->container->getParameter('twilio.sid');
        $token = $this->container->getParameter('twilio.token');

        $twilio = new Twilio\Twilio($sid, $token);

        $numbers = $twilio->account->available_phone_numbers->getList('GB', 'Local', array('Contains' => 44));
        var_dump($numbers);
    }
}
