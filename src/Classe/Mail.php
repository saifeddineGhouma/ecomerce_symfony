<?php

namespace App\Classe ;

use Mailjet\Client;
use Mailjet\Resources;

class Mail 
{
    private $api_key = '4d0467aca33db2e8aded742739de6938';
    private $api_key_secret = '529f169b5d684b5fbb9a19180dd6b55f';

    public function send($_to_email,$_to_name,$_subject,$_content)
    {
        $mj = new Client($this->api_key,$this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
          'Messages' => [
            [
              'From' => [
                'Email' => "saifgouma@gmail.com",
                'Name' => "ghouma"
              ],
              'To' => [
                [
                  'Email' => $_to_email,
                  'Name' => $_to_name
                ]
              ],
                'TemplateID' => 2436023,
                'TemplateLanguage' => true,
                'Subject' => $_subject,
                'Variables' => [
                    'content'=>$_content
                ]
            ]
          ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }

}
