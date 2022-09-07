<?php 
namespace App\Requests;

class MyBaseRequest
{
    protected $validation;
    protected $request;
    protected $response;

    public function __construct()
    {
        $this->validation= service('validation');
        $this->request= service('request');
        $this->response= service('response');
    }

    protected function validation(string $ruleGroup, bool $repondWithRedirect= false)
    {
        $this->validation->setRuleGroup($ruleGroup);

        if(!$this->validation->withRequest($this->request)->run()){

            //Formulario não foi validado

            if($repondWithRedirect){

                //
                $this->respondWithRedirect();

            }

            $this->respondWithValidationErrors();
       }

      
    }

    private function respondWithRedirect()
    {
        redirect()->back()->with('danger',lang('App.danger_validations'))
        ->with( 'errors_model', $this->validation->getErrors())
        ->withInput()
        ->send();
        exit;// não esquecer do exit
    }

    private function respondWithValidationErrors(): array
    {
    
        $response = [
            'success'=> false,
            'token' => csrf_hash(),
            'errors' => $this->validation->getErrors(),
        ];

        if(url_is('api*')){
            unset( $response['token']);

        }
        $this->response->setJSON($response)->send();
        exit; //interropemos o execução do codigo
    }

    public function respondWithMessage(bool $success = true, string $message = '', int $statusCode=200):array
    {

         $response = [
            'code'=> $statusCode,
            'success'=> $success,
            'token' => csrf_hash(),
            'message' => $message
            ];

            if(url_is('api*')){

                unset($response['token']);
            }
            return $response;
    }
}