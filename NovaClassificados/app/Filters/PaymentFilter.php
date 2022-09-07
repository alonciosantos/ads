<?php

namespace App\Filters;

use App\Services\gerencianetService;
use CodeIgniter\Config\Factories;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class PaymentFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */

    protected $response;
    protected $gerencianetService;

    public function __construct()
    {
        $this->response             = service('response');
        $this->gerencianetService   = Factories::class(gerencianetService::class);
    }
    

    public function before(RequestInterface $request, $arguments = null)
    {
        if(!$request->isAJAX()){

            $userSubscription = $this->gerencianetService->getUserSubscription();

            if(!$userSubscription->is_paid){

                // se foi api Url, retornamos uma messagem para o usuario/anunciante
                if(url_is('api*')){ 

                    return $this->fail('Oooops.... Ainda não identificamos o pagamento do seu plano!', ResponseInterface::HTTP_UNAUTHORIZED);

                }
                // se nao for api Url , voltamos e  retornamos a uma messagem para o usuario/anunciante
               // return redirect()->route('dashboard')->with('danger','oooops.... verficamos que voçê ainda não possui um plano');
               return redirect()->back()->with('danger','Oooops.... Ainda não identificamos o pagamento do seu plano!.');
            }
        }
        
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
