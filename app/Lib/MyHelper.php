<?php
namespace App\Lib;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class MyHelper
{

    public static function postLogin($request){
        $api = env('API_URL');

        $client = new Client;
        try {
            $response = $client->request('POST',$api.'/api/login', [
                'form_params' => [
                    'email'    => $request['email'],
                    'password' => $request['password'],
                ],
            ]);
            return json_decode($response->getBody(), true);
        }catch (\GuzzleHttp\Exception\RequestException $e) {
            try{
                if($e->getResponse()){
                    $response = $e->getResponse()->getBody()->getContents();
                    return json_decode($response, true);
                }
                else{
                    return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
                }

            }
            catch(Exception $e){
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

    public static function get($url){
        $api = env('API_URL');

        $client = new Client;

        $ses = session('access_token');

        $content = array(
            'headers' => [
                'Authorization'   => $ses,
                'Accept'          => 'application/json',
                'Content-Type'    => 'application/json',
                'ip-address-view' => Request::ip(),
                'user-agent-view' => $_SERVER['HTTP_USER_AGENT'],
            ]
        );

        try {
            $response =  $client->request('GET',$api.'/api/'.$url, $content);
            return json_decode($response->getBody(), true);
        }
        catch (\GuzzleHttp\Exception\RequestException $e) {
            try{
                if($e->getResponse()){
                    $response = $e->getResponse()->getBody()->getContents();
                    $error = json_decode($response, true);

                    if(!$error) {
                      return $e->getResponse()->getBody();
                    }else {
                      if(isset($error['error']) && $error['error'] == 'Unauthenticated.') {
                        Session::forget('name');
                        Session::forget('email');
                      }
                      return $error;
                    }
                }
                else return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];

            }
            catch(Exception $e){
                return ['status' => 'fail', 'messages' => [0 => 'Check your internet connection.']];
            }
        }
    }

}
