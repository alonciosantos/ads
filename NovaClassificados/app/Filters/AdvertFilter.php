<?php

namespace App\Filters;

use App\Services\gerencianetService;
use CodeIgniter\Config\Factories;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class AdvertFilter implements FilterInterface
{
    use ResponseTrait;
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
    //protected $request;
    protected $gerencianetService;

    public function __construct()
    {
        $this->response             = service('response');
        $this->gerencianetService   = Factories::class(gerencianetService::class);
    }


    public function before(RequestInterface $request, $arguments = null)
    {
        //dd($this->gerencianetService->userReachedAdvertsLimit());
        if($this->gerencianetService->userReachedAdvertsLimit()){

                   

    // contamos quantos anuncios o user logado possui
        $countUserAdverts = $this->gerencianetService->countAllUserAdverts();
        $countFeaturesAdverts = $this->gerencianetService->getUserSubscription()->features->adverts;

            // se foi api Url, retornamos uma messagem para o usuario/anunciante
           if (url_is('api/adverts/create*') || $request->isAJAX()) {

                return $this->fail("Voçê já cadastrou {$countUserAdverts} anúncios. Seu Plano contempla o cadastro de {$countFeaturesAdverts} anúncios. Para continuar, voçê poderá migrar de Plano",ResponseInterface::HTTP_UNAUTHORIZED);
            }
            // se nao for api Url , voltamos e  retornamos a uma messagem para o usuario/anunciante
            // return redirect()->route('dashboard')->with('danger','oooops.... verficamos que voçê ainda não possui um plano');
            return redirect()->back()->with('danger', "Voçê já cadastrou {$countUserAdverts} anúncios. Seu Plano contempla o cadastro de {$countFeaturesAdverts} anúncios. Para continuar, voçê poderá migrar de Plano");
            //redirect()->route('dashboard');
        }
    }
       
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
