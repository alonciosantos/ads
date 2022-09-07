<?php

namespace App\Controllers;

use App\Requests\GerencianetRequest;
use App\Services\AdvertService;
use App\Services\CategoryService;
use App\Services\gerencianetService;
use App\Services\PlanService;
use App\Services\UserService;
use CodeIgniter\Config\Factories;

use function PHPUnit\Framework\returnSelf;

class HomeController extends BaseController
{

    private $planService;
    private $userService;
    private $gerencianetRequest;
    private $gerencianetService;
    private $advertService;
    

    public function __construct()
    {
        $this->planService = Factories::class(PlanService::class);
        $this->userService = Factories::class(UserService::class);
        $this->gerencianetRequest = Factories::class(GerencianetRequest::class);
        $this->gerencianetService = Factories::class(gerencianetService::class);
        $this->advertService = Factories::class(AdvertService::class);
        
    }


    public function index()
    {
        //dd(categories_adverts(5));
        //d(cities_adverts(categorySlug:'shorts'));
        $advertsForHome = (object) $this->advertService->getAllAdvertsPaginated(perPage:6);

        //dd($advertsForHome);
        $data = [
            'title'         => 'Anúncios Recentes',
            'adverts'       => $advertsForHome->adverts,
            'pager'         => $advertsForHome->pager,
        ];
        return view('Web/Home/index', $data);
    }

    public function pricing()
    {
        $data = [
            'title' => 'Conheça os nossos planos',
            'plans' => $this->planService->getPlansToSell(),
        ];
        return view('Web/Home/pricing', $data);
    }


    public function choice(int $planID = null)
    {

        /**
         * @todo verificar se o user logado ja tem assinatura
         */
        if ($this->gerencianetService->userHasSubscription()) {

            return redirect()->route('dashboard')->with('info', 'Voçê já possui uma Assinatura. Aproveite para cancela-la e adquirir o novo Plano.');
        }



        /**
         * @todo verificar se o user logado esta com os dados completos da gerencianet
         *
         */
        $plan = $this->planService->getChoosenPlan($planID);

        if (!$this->userService->userDataIsComplete()) {
            // usaremos para redirecionar após o user atualizar o perfil. Esse trecho é para o caso de o user ter logado antes de tentar comprar o plano.
            session()->set('choice', current_url());


            // criar na entidade User.php o metodo para exibir a mensagem de flashdata adequada - flashMessageToUser
            return redirect()->route('profile')->with('info', service('auth')->user()->flashMessageToUser());
        }

        $data = [
            'title' => "Realizar o pagamento do Plano {$plan->name}",
            'plan' => $plan,
        ];
        return view('Web/Home/choice', $data);
    }

    public function attemptPay(int $planID = null)
    {


        $this->gerencianetRequest->validateBeforeSave($this->request->getPost('payment_method'));

        $plan = $this->planService->getChoosenPlan($planID);

        $request = (object)$this->removeSpoofingFromRequest();

        /**
         * @todo criar regra para capturar quando for boleto, queremos devolver para o anunciante o QRCODE
         */
        if ($request->payment_method == $this->gerencianetService::PAYMENT_METHOD_BILLET) {
            $qrcodeImage = $this->gerencianetService->createSubscription($plan, $request);

            $qrcodeImageBuilded = img(['src' => $qrcodeImage, 'width' => '150px']);

            session()->setFlashdata('success', "Muito ogrigado!. Aproveite para realizar o pagamento do seu Boleto Báncario com PIX: <br/><br/><center>{$qrcodeImageBuilded}</center>");

            return $this->response->setJSON($this->gerencianetRequest->respondWithMessage('Muito ogrigado!Estamos aguardando a confirmação do pagamento.'));
        }

        $this->gerencianetService->createSubscription($plan, $request);

        session()->setFlashdata('success', 'Muito ogrigado!. Estamos aguardando a confirmação do pagamento.');

        return $this->response->setJSON($this->gerencianetRequest->respondWithMessage('Muito ogrigado!Estamos aguardando a confirmação do pagamento.'));
    }

    public function userAverts(string $userName = null)
    {
        $user = $this->userService->getUserByCriteria(['username' => $userName]);
        //d($user->id);
        $advertsForHome = (object) $this->advertService->getAllAdvertsPaginated(perPage:10, criteria: ['adverts.user_id' => $user->id]);
        //dd($advertsForHome->adverts);
        $userName = $user->name ?? $user->username;
        
        $data = [
            'title'         => "Anúncios do usúario {$userName}",
            'adverts'       => $advertsForHome->adverts,
            'pager'         => $advertsForHome->pager,
        ];
        return view('Web/Home/adverts_by_username', $data);
    }

    public function category(string $categorySlug = null,)
    {
        $category = Factories::class(CategoryService::class)->getCategoryBySlug($categorySlug);
       // dd($category);
       $adverts = (object) $this->advertService->getAllAdvertsPaginated(perPage:10, criteria: ['categories.slug' => $category->slug]);
       //dd($advertsForHome->adverts);
       
       
       $data = [
           'title'         => "Resultados para a Categoria \"{$category->name}\"",
           'adverts'       => $adverts->adverts,
           'pager'         => $adverts->pager,
           'category'      => $category,
       ];
       return view('Web/Home/adverts_by_category', $data);
    }

    public function categoryCity(string $categorySlug = null, string $citySlug= null )
    {

        $category = Factories::class(CategoryService::class)->getCategoryBySlug($categorySlug);
        $criteria =[
            'categories.slug'       => $category->slug,
            'adverts.city_slug'     => $citySlug,
        ];
        $adverts = (object) $this->advertService->getAllAdvertsPaginated(perPage:10, criteria: $criteria);

        $city = array_column($adverts->adverts,'city')[0];

        

        $data = [
            'title'         => "\"{$category->name}\" em \"{$city}\"",
            'adverts'       => $adverts->adverts,
            'pager'         => $adverts->pager,
            'category'      => $category,
        ];

        
        return view('Web/Home/adverts_by_category_city', $data);

       
    }

    public function search()
    {
        if(!$this->request->isAJAX()){

            return redirect()->back();

        }

        return $this->response->setJSON($this->advertService->getAllAdvertByTerm($this->request->getGet('term')));
    }

}
