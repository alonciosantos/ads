<?php

namespace App\Services;

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

use Config\App;
use App\Entities\plan;
use App\Models\AdvertModel;
use CodeIgniter\Config\Factories;
use Exception;
use App\Services\SubscriptionService;
use phpDocumentor\Reflection\Types\This;
use stdClass;

class gerencianetService
{
    public const  PAYMENT_METHOD_BILLET     = 'billet';
    public const  PAYMENT_METHOD_CREDIT     = 'credit';

    //sera usa apenas no escopo da classe
    private const STATUS_NEW                = 'new';
    private const STATUS_WAITING            = 'waiting';
    private const STATUS_PAID               = 'paid';
    private const STATUS_UNPAID             = 'unpaid';
    private const STATUS_REFUNDED           = 'refunded';
    private const STATUS_CONTESTED          = 'contested';
    private const STATUS_SETTLED            = 'settled';
    private const STATUS_CANCELED           = 'canceled';

    private $options;
    private $user;                  // usuario que estiver logado
    private $subscriptionService;
    private $userSubscription;

    public function __construct()
    {
        $this->options = [
            'client_id'         => env('GERENCIANET_CLIENT_ID'), // ver .env
            'client_secret'     => env('GERENCIANET_CLIENT_SECRET'), // ver .env
            'sandbox'           => env('GERENCIANET_SANDBOX'), // true  = Homologação e false = produção
            'timeout'           => env('GERENCIANET_TIMEOUT') // ver .env

        ];
        //pega o usuario logado
        $this->user = service('auth')->user();

        $this->subscriptionService = Factories::class(SubscriptionService::class);
        // $this->subscriptionsService = Factories::class(SubscriptionService::class);
    }


    public function createPlan(Plan $plan)
    {
        //codigo error 10021
        // Definimos a periocidade das cobranca geradas
        $plan->setIntevalRepeats();

        $body = [
            'name' => $plan->name,
            'interval' => $plan->interval,
            'repeats' => $plan->repeats,
        ];

        try {
            // $api = new Gerencianet($options);
            $api = new Gerencianet($this->options);
            $response = $api->createPlan([], $body); // requesição na gerencianet e retorna o resposta

            // pega o id retornado pelo gerencianet para 
            //atualiza o plan_id no banco de dados
            $plan->plan_id = (int) $response['data']['plan_id'];  // referencia com PlanService linha 155


            //echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
            // exit; //remover debug
        } catch (GerencianetException $e) {
            /* print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);*/
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Code  10021 :Erro ao criar plano na gerencianet');

            // } catch (Exception $e) {
        } catch (\Exception $e) {
            //print_r($e->getMessage());

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Code  10021 :Erro ao criar plano na gerencianet');
        }
    }

    public function updatePlan(Plan $plan)
    {
        $params = ['id' => $plan->plan_id];

        $body = ['name' => $plan->name];

        try {
            $api = new Gerencianet($this->options);
            $response = $api->updatePlan($params, $body);

            // echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
        } catch (GerencianetException $e) {
            /*  print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);*/

            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Code  10031 :Erro ao atualizar plano na gerencianet');
        } catch (\Exception $e) {
            //print_r($e->getMessage());
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Code  10031 :Erro ao atualizar plano na gerencianet');
        }
    }

    public function deletePlan(int $PlanID)
    {

        $params = ['id' => $PlanID];

        try {
            $api = new Gerencianet($this->options);
            $response = $api->deletePlan($params, []);

            // echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
        } catch (GerencianetException $e) {
            /*  print_r($e->code);
        print_r($e->error);
        print_r($e->errorDescription);*/
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Code  10038 :Erro ao excluir plano na gerencianet');
        } catch (\Exception $e) {
            // print_r($e->getMessage());
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Code  10038 :Erro ao excluir plano na gerencianet');
        }
    }

    //-------------------------------Gerenciamento de Assinaturas-------------------------//
    public function createSubscription(Plan $choosenPlan, object $request)
    {


        $params = ['id' => $choosenPlan->plan_id];

        $items = [
            [
                'name' => $choosenPlan->name,
                'amount' => 1,
                // valor (1000 = R$10,00) (obs: É possivel a criação de itens com valores negativos, 
                //Porém o valor  total da fatura deve ser superior ao valor minimo para geração de transações.)
                'value' => (int) str_replace([',', '.'], '', $choosenPlan->value)
            ],

        ];

        $body = [
            'items' => $items
        ];


        try {

            /*
                    <pre>{
                        "code": 200,
                        "data": {
                            "subscription_id": 65701,
                            "status": "new",
                            "custom_id": null,
                            "charges": [
                                {
                                    "charge_id": 1672388,
                                    "status": "new",
                                    "total": 1990,
                                    "parcel": 1
                                }
                            ],
                            "created_at": "2022-08-14 16:44:52"
                        }
                    }</pre>*/

            $api = new Gerencianet($this->options);
            $response = $api->createSubscription($params, $body);

            $choosenPlan->subscription_id = (int) $response['data']['subscription_id'];


            //Avaliar quando for boleto para obetrmos o QRCODE da gerencianet

            if ($request->payment_method == self::PAYMENT_METHOD_BILLET) {
                //sim..

                $qrcodeImage = $this->paySubscription($choosenPlan, $request);

                return $qrcodeImage;
            }



            $this->paySubscription($choosenPlan, $request);

            // echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';


            //  exit;
        } catch (GerencianetException $e) {
            /* print_r($e->code);
                    print_r($e->error);
                    print_r($e->errorDescription);*/

            // print_r($e->getMessage());
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro ao criar assinatura na gerencianet');
        } catch (Exception $e) {
            // print_r($e->getMessage());

            // print_r($e->getMessage());
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro ao criar assinatura na gerencianet');
        }
    }

    public function userHasSubscription(): bool
    {
        return $this->subscriptionService->userHasSubscription();
    }

    public function reasonCharge(string $status): string
    {
        $message = match ($status) {

            self::STATUS_NEW        => 'Cobrança gerada, aguardando definição da forma de pagamento',
            self::STATUS_WAITING    => 'Aguardando a confirmação do pagamento.',
            self::STATUS_PAID       => 'Pagamento confirmado',
            self::STATUS_UNPAID     => 'Não foi possivel confirmar o pagamento da conbrança',
            self::STATUS_REFUNDED   => 'Pagamento devolvido pelo logista ou pelo intermediador Gerencianet',
            self::STATUS_CONTESTED  => 'Pagamento em processo de contestação',
            self::STATUS_SETTLED    => 'Cobrança paga manualmente',
            self::STATUS_CANCELED   => 'Cobrança cancelada',

            default                 => 'Status de pagamento desconhecido',
        };

        return $message;
    }


    private function handleBillingHistory(array $history): bool
    {
        $this->userSubscription->is_paid = false;

        $isPaid = false;

        foreach ($history as $charge) {

            $this->userSubscription->reason_charge = $this->reasonCharge($charge['status']);

            if ($charge['status'] == self::STATUS_PAID || $charge['status'] == self::STATUS_SETTLED) {

                $isPaid = true;

                $this->userSubscription->is_paid = true;

                $this->userSubscription->charge_not_paid = null;

                $this->userSubscription->valid_until = date('Y-m-d H:i:s', time() + 3600); // 60 minutos
            } else {
                // não esta paga?

                $isPaid = false;

                $this->userSubscription->is_paid = false;

                $this->userSubscription->charge_not_paid = $charge['charge_id'];

                $this->userSubscription->valid_until = null; // torna ele nulo novamente

                break;
            }
        }
        //Nesse ponto, ja definimos a situação do objeto $this->userSubscription, ou seja, diversas prodpriedades doram definidas.
        //Portanto, chegou o momento de atualizar a assinatura na nossa base de dados.
        $this->subscriptionService->trySaveSubscription($this->userSubscription);
        //retornamos se está pago ou não (true ou false)
        return $isPaid;
    }

    public function cancelSubscription()
    {
        $this->getUserSubscription();
        $params = ['id' => $this->userSubscription->subscription_id];

try {
    $api = new Gerencianet($this->options);
    $response = $api->cancelSubscription($params, []);

    $this->subscriptionService->tryDestroyUserSubscription($this->userSubscription->subscription_id);


    //echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
} catch (GerencianetException $e) {
    log_message('error', '[ERROR] {exception}', ['exception' => $e->errorDescription]);

    die('Erro ao cancelar assinatura na gerencianet');

} catch (\Exception $e) {
    log_message('error', '[ERROR] {exception}', ['exception' => $e->errorDescription]);

    die('Erro ao cancelar assinatura na gerencianet');
}

    }

    private function paySubscription(Plan $choosenPlan, object $request)
    {
        // Forma de pagamento por cartão de crédito ("credit_card")

        $params = ['id' => $choosenPlan->subscription_id];

        $customer = [
            'name'              => $this->user->fullname(),
            'cpf'               => str_replace(['.', '-'], '', $this->user->cpf),
            'phone_number'      => str_replace(['(', ')', ' ', '-'], '', $this->user->phone),
            'email'             => $this->user->email,
            'birth'              => $this->user->birth,
        ];

        $billingAddress = [
            'street'                => $request->street,
            'number'                => ($request->number ? (int)$request->number : 'Não informado'),
            'neighborhood'          => $request->neighborhood,
            'zipcode'               => str_replace(['.', '-'], '', $request->zipcode),
            'city'                  => $request->city,
            'state'                 => $request->state,
        ];

        // É Boleto?
        if ($request->payment_method == self::PAYMENT_METHOD_BILLET) {
            //sim..

            $body = [
                'payment' => [
                    'banking_billet' => [
                        'expire_at'         => $request->expire_at,
                        'customer'          => $customer
                    ]
                ]
            ];
        } else {
            // Não .. e cartao de redito

            $body = [
                'payment' => [
                    'credit_card' => [
                        'billing_address'     => $billingAddress,
                        'payment_token'       => $request->payment_token,
                        'customer'            => $customer,
                    ]
                ]
            ];
        }


        try {


            /* <pre>{
                "code": 200,
                "data": {
                    "subscription_id": 65728,
                    "status": "active",
                    "barcode": "00000.00000 00000.000000 00000.000000 0 00000000000000",
                    "pix": {
                        "qrcode": "Este QRCode não pode ser pago, ele foi gerado em ambiente sandbox da Gerencianet.",
                        "qrcode_image": "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMyAzMyIgc2hhcGUtcmVuZGVyaW5nPSJjcmlzcEVkZ2VzIj48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNMCAwaDMzdjMzSDB6Ii8+PHBhdGggc3Ryb2tlPSIjMDAwMDAwIiBkPSJNMCAwLjVoN200IDBoMm0xIDBoMW00IDBoMW0yIDBoMW0xIDBoMW0xIDBoN00wIDEuNWgxbTUgMGgxbTUgMGgxbTMgMGgzbTEgMGgxbTMgMGgxbTEgMGgxbTUgMGgxTTAgMi41aDFtMSAwaDNtMSAwaDFtMSAwaDJtMSAwaDJtMiAwaDJtMSAwaDRtMSAwaDJtMSAwaDFtMSAwaDNtMSAwaDFNMCAzLjVoMW0xIDBoM20xIDBoMW0xIDBoMW00IDBoMW0zIDBoMW0zIDBoMW0xIDBoMW0yIDBoMW0xIDBoM20xIDBoMU0wIDQuNWgxbTEgMGgzbTEgMGgxbTQgMGgxbTEgMGgxbTMgMGgybTEgMGgxbTIgMGgybTEgMGgxbTEgMGgzbTEgMGgxTTAgNS41aDFtNSAwaDFtMiAwaDFtMiAwaDZtMyAwaDFtMSAwaDFtMiAwaDFtNSAwaDFNMCA2LjVoN20xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoN005IDcuNWgxbTEgMGgxbTEgMGgxbTEgMGgybTEgMGgybTQgMGgxTTMgOC41aDJtMSAwaDJtMSAwaDJtMSAwaDJtMSAwaDFtNCAwaDFtMyAwaDFtNCAwaDJNNSA5LjVoMW0yIDBoMm0zIDBoMm0xIDBoMW0xIDBoMW0yIDBoNW0xIDBoNE0wIDEwLjVoMW0xIDBoNm0xIDBoMW0xIDBoMm0yIDBoMm0yIDBoMm0xIDBoMm0xIDBoM20yIDBoM00wIDExLjVoMW0zIDBoMm0xIDBoMW0yIDBoMW0yIDBoMm0xIDBoMW0xIDBoMm0xIDBoM20xIDBoMW0xIDBoMm0xIDBoM00wIDEyLjVoNG0yIDBoMW0xIDBoMm0xIDBoMW0zIDBoMm00IDBoMW0yIDBoMW0xIDBoM20zIDBoMU0wIDEzLjVoM200IDBoMW0yIDBoMW0xIDBoMm0xIDBoMW0xIDBoMW0zIDBoMW0xIDBoMW0xIDBoMW0xIDBoM20xIDBoMU0zIDE0LjVoNW0xIDBoMm0xIDBoMW0xIDBoMW01IDBoMW00IDBoMW0xIDBoMU0wIDE1LjVoMW0yIDBoMm0yIDBoMW00IDBoMm0xIDBoMm0xIDBoMW00IDBoM20xIDBoMW0xIDBoMU0wIDE2LjVoMW0xIDBoMW0yIDBoMm0xIDBoMm0yIDBoMm0xIDBoMm0xIDBoMW0xIDBoMW0yIDBoMW0xIDBoNk0wIDE3LjVoM20xIDBoMm01IDBoMm0yIDBoMW0zIDBoMm0xIDBoMW0xIDBoMW0xIDBoNE0yIDE4LjVoMW0xIDBoM203IDBoMW0xIDBoMm0yIDBoNG0xIDBoM20xIDBoNE0yIDE5LjVoMW0xIDBoMW0yIDBoMm0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoNG0yIDBoM20xIDBoNk0wIDIwLjVoMm0xIDBoMm0xIDBoMW0xIDBoMm0xIDBoM201IDBoMW00IDBoMm0xIDBoMW0xIDBoMW0xIDBoMU0wIDIxLjVoMm0xIDBoMm0yIDBoMm0xIDBoMW0yIDBoMW0xIDBoMm0xIDBoM20xIDBoMW0yIDBoNk0wIDIyLjVoMW0xIDBoMW0xIDBoM20yIDBoNm0yIDBoMW0xIDBoMm0zIDBoMW0xIDBoM20xIDBoM00wIDIzLjVoMW0yIDBoMW0xIDBoMW02IDBoMm0yIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW01IDBoMW0xIDBoMW0xIDBoMU0wIDI0LjVoMm00IDBoMW02IDBoMW0xIDBoMW0xIDBoNG0zIDBoNU04IDI1LjVoM20xIDBoMm0xIDBoMW0xIDBoMW0xIDBoMm0xIDBoMW0xIDBoMW0zIDBoNE0wIDI2LjVoN20xIDBoNG0xIDBoMm0xIDBoMW0xIDBoMW0yIDBoNG0xIDBoMW0xIDBoMW0xIDBoMU0wIDI3LjVoMW01IDBoMW0yIDBoMW02IDBoM20xIDBoMW0yIDBoMm0zIDBoMW0xIDBoMk0wIDI4LjVoMW0xIDBoM20xIDBoMW0xIDBoMW0zIDBoMW0zIDBoMm0zIDBoMW0xIDBoN20xIDBoMU0wIDI5LjVoMW0xIDBoM20xIDBoMW0xIDBoMW0yIDBoMW0zIDBoMW0zIDBoM20zIDBoMW0xIDBoMW0xIDBoM00wIDMwLjVoMW0xIDBoM20xIDBoMW0zIDBoMW0xIDBoM20yIDBoMm0xIDBoMW03IDBoMW0xIDBoM00wIDMxLjVoMW01IDBoMW0zIDBoM20yIDBoM20zIDBoMW04IDBoM00wIDMyLjVoN20yIDBoMW0yIDBoMW0yIDBoMm0yIDBoMW0xIDBoMW0xIDBoNG0xIDBoMyIvPjwvc3ZnPg=="
                    },
                    "link": "https://download.gerencianet.com.br/v1/30134_2_FOXI3/30134-2-DOLO9?sandbox=true",
                    "billet_link": "https://visualizacaosandbox.gerencianet.com.br/emissao/30134_2_FOXI3/A4XB-30134-2-DOLO9",
                    "pdf": {
                        "charge": "https://download.gerencianet.com.br/30134_2_FOXI3/30134-2-DOLO9.pdf?sandbox=true"
                    },
                    "expire_at": "2022-08-18",
                    "plan": {
                        "id": 9337,
                        "interval": 1,
                        "repeats": null
                    },
                    "charge": {
                        "id": 1672640,
                        "status": "waiting",
                        "parcel": 1,
                        "total": 1990
                    },
                    "first_execution": "15/08/2022",
                    "total": 1990,
                    "payment": "banking_billet"
                }
            }</pre>*/


            /*
             <pre>{
            "code": 200,
            "data": {
                "subscription_id": 65730,
                "status": "active",
                "plan": {
                    "id": 9337,
                    "interval": 1,
                    "repeats": null
                },
                "charge": {
                    "id": 1672647,
                    "status": "waiting",
                    "parcel": 1,
                    "total": 1990
                },
                "first_execution": "15/08/2022",
                "total": 1990,
                "payment": "credit_card"
            }
            }</pre>
                        */


            $api = new Gerencianet($this->options);

            $response = $api->paySubscription($params, $body);

            $this->subscriptionService->tryInsertSubscription($choosenPlan, $response['data']);

            // echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
            // exit;
            $this->removeSessionData();

            //QRCODE 
            if ($request->payment_method == self::PAYMENT_METHOD_BILLET) {
                //sim..

                return $response['data']['pix']['qrcode_image'];
            }
        } catch (GerencianetException $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e->errorDescription]);

            die('Erro ao pagar assinatura na gerencianet');
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e->errorDescription]);

            die('Erro ao pagar assinatura na gerencianet');
        }
    }


    private static function  removeSessionData(): void
    {
        $data = [
            'intended',
            'choice',
        ];

        session()->remove($data);
    }

    public function detailSubscription(int $subscriptionID): array
    {

        $params = ['id' => $subscriptionID];

        try {
            $api = new Gerencianet($this->options);

            $response = $api->detailSubscription($params, []);

            return $response['data'];

            //  echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';

            //  exit;
        } catch (GerencianetException $e) {
            /*print_r($e->code);
            print_r($e->error);
            print_r($e->errorDescription);*/
            log_message('error', '[ERROR] {exception}', ['exception' => $e->errorDescription]);

            die('Erro ao detalhar assinatura na gerencianet');
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e->errorDescription]);

            die('Erro ao detalhar assinatura na gerencianet');
        }
    }

    public function getUserSubscription()
    {
        // se usersubscription continua nulo? 
        if (is_null($this->userSubscription)) {
            //se sim
            $this->userSubscription = $this->subscriptionService->getUserSubscription();

            //  dd($this->userSubscription);
        }
        //ainda continua nulo? ou seja , user possui assinatura?
        if (is_null($this->userSubscription)) {
            return null;
        }
        // nesse ponto o user possui assinatura
        //devemos agora consultar o status de pagamento atual na gerencianet

        // devemos consultar novamente a gerencianet?
        if (!$this->userSubscription->isValid()) {

            //sim .. a assinatura não é mais valida aqui do nosso lado.

            $details = $this->detailSubscription($this->userSubscription->subscription_id);

            //dd($details);

            //User tem assinatura, mas precisamos verificar se foi cancelada
            //Isso pode ter ocorrido quando o user cancelou
            //atraves do e-mail que a gerencianet envia
            //ou seja, não foi pelo nosso dashboard.
            //É importante destacar que o cancelamento pelo e-mail,
            //so funciona quando estamos em ambiente de produção

            if ($details['status'] == self::STATUS_CANCELED) {

                $this->subscriptionService->tryDestroyUserSubscription($this->userSubscription->subscription_id);

                //user não possui mas assinatura aqui do nosso lado
                return null;
            }

            $this->defineSubscriptionSituation($details);
        }
        return $this->userSubscription;
    }
    
    //pega quantos anuncios o usuario pode cadastrar
    public function userReachedAdvertsLimit():bool
    {
        //user tem assinatura?
        if(!$this->userHasSubscription())
        {
            //Não... , então , podemos dizer que ele alcançou o limit
            return true;
        }

        //consultamos se necessario a assinatura do user logado e populamos a propriedade $userSubcription
        $this->getUserSubscription();

        //pode cadastrar ilimitadamentes?
        if(is_null($countFeaturesAdverts = $this->userSubscription->features->adverts))
        {
            //Sim.. pode cadastrar sem limites
            return false;
        }
        //contamos quantos anuncios o user logado possui?
        $countUserAdverts = $this->countAllUserAdverts();

        //verificamos se o user atingiu o limite , confrontando o numero de adverts 
        //se for maior ou igual  ao numero de anuncios criados pelo user, no plano(features) da compra?
        if($countUserAdverts >= $countFeaturesAdverts)
        {
            //Sim ... o numero e maior ou igual, já alcançou o limite e não pode mais continuar
            return true;
        }

        //ainda não alcançou limite , ele pode continuar cadastrando
        return false;

    }

    //verifica quantos anuncio o usuario logado ja tem cadastrado.
    public function countAllUserAdverts( bool $withDeleted = true, array $criteria = []):int
    {
        if(!$this->userHasSubscription())
        {
            return 0; //retorno e inteiro
        } 
        
        return Factories::models(AdvertModel::class)->countAllUserAdverts($this->user->id, $withDeleted, $criteria);
    }

    //**********METODOS PRIVADOS***********//
    private function defineSubscriptionSituation(array $details)
    {

        if (empty($details)) { // verificase detail tem algum conteudo
            return false;
        }
        // se tiver armazena os dados
        $this->userSubscription->status = $details['status']; //armazena o status
        $this->userSubscription->history = $details; //armazena todo o array $details

        return $this->handleBillingHistory($details['history']);
    }

    public function detailCharge(int $chargeID)
    {
        $params = ['id' => $chargeID];

        try {
            $api = new Gerencianet($this->options);

            $response = $api->detailCharge($params, []);

            return $this->preparesChargeForView($response['data']);
        
           // echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</pre>';
        } catch (GerencianetException $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro ao detalhar cobrança na gerencianet');
        } catch (\Exception $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);

            die('Erro ao detalhar cobrança na gerencianet');
        }
    }

    private function preparesChargeForView(array $chargeData):object
    {
        $chargeData = esc($chargeData);
        $charge = new stdClass;

        $charge->charge_id          = $chargeData['charge_id'];

        $charge->payment_method     = $chargeData['payment']['method'];
        $charge->status             = $chargeData['status'];

        //é boleto?
        if(isset($chargeData['payment']['banking_billet'])){
                       
            $charge->url_pdf        =  $chargeData['payment']['banking_billet']['pdf']['charge'];
            $charge->expire_at      = date('d-m-Y',strtotime($chargeData['payment']['banking_billet']['expire_at']));
        }

        $charge->created_at         = date('d-m-Y',strtotime($chargeData['created_at']));
        $charge->history            = $chargeData['history'];

        return $charge; // retornamos o $charge que é o objeto
        
        /*
            "charge_id": 1674518,
            "total": 5500,
            "status": "waiting",
            "subscription": {
                "subscription_id": 65872,
                "status": "active",
                "plan_id": 9338
            },
            "custom_id": null,
            "created_at": "2022-08-19 17:04:02",
            "notification_url": null,
            "items": [
                {
                    "name": "Plano Trimestral",
                    "value": 5500,
                    "amount": 1
                }
            ],
            "history": [
                {
                    "message": "Cobrança criada",
                    "created_at": "2022-08-19 17:04:02"
                },
                {
                    "message": "Pagamento via boleto aguardando confirmação",
                    "created_at": "2022-08-19 17:04:06"
                },
                {
                    "message": "Cobrança enviada para alonciocarvalho@gmail.com",
                    "created_at": "2022-08-19 17:04:07"
                }
            ],
            "customer": {
                "name": "Teste Tester",
                "cpf": "02106242301",
                "birth": "1983-04-22",
                "email": "alonciocarvalho@gmail.com",
                "phone_number": "86986323232"
            },
            "payment": {
                "method": "banking_billet",
                "created_at": "2022-08-19 17:04:04",
                "message": null,
                "banking_billet": {
                    "barcode": "00000.00000 00000.000000 00000.000000 0 00000000000000",
                    "pix": {
                        "qrcode": "Este QRCode não pode ser pago, ele foi gerado em ambiente sandbox da Gerencianet.",
                        "qrcode_image": "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMyAzMyIgc2hhcGUtcmVuZGVyaW5nPSJjcmlzcEVkZ2VzIj48cGF0aCBmaWxsPSIjZmZmZmZmIiBkPSJNMCAwaDMzdjMzSDB6Ii8+PHBhdGggc3Ryb2tlPSIjMDAwMDAwIiBkPSJNMCAwLjVoN200IDBoMm0xIDBoMW00IDBoMW0yIDBoMW0xIDBoMW0xIDBoN00wIDEuNWgxbTUgMGgxbTUgMGgxbTMgMGgzbTEgMGgxbTMgMGgxbTEgMGgxbTUgMGgxTTAgMi41aDFtMSAwaDNtMSAwaDFtMSAwaDJtMSAwaDJtMiAwaDJtMSAwaDRtMSAwaDJtMSAwaDFtMSAwaDNtMSAwaDFNMCAzLjVoMW0xIDBoM20xIDBoMW0xIDBoMW00IDBoMW0zIDBoMW0zIDBoMW0xIDBoMW0yIDBoMW0xIDBoM20xIDBoMU0wIDQuNWgxbTEgMGgzbTEgMGgxbTQgMGgxbTEgMGgxbTMgMGgybTEgMGgxbTIgMGgybTEgMGgxbTEgMGgzbTEgMGgxTTAgNS41aDFtNSAwaDFtMiAwaDFtMiAwaDZtMyAwaDFtMSAwaDFtMiAwaDFtNSAwaDFNMCA2LjVoN20xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoN005IDcuNWgxbTEgMGgxbTEgMGgxbTEgMGgybTEgMGgybTQgMGgxTTMgOC41aDJtMSAwaDJtMSAwaDJtMSAwaDJtMSAwaDFtNCAwaDFtMyAwaDFtNCAwaDJNNSA5LjVoMW0yIDBoMm0zIDBoMm0xIDBoMW0xIDBoMW0yIDBoNW0xIDBoNE0wIDEwLjVoMW0xIDBoNm0xIDBoMW0xIDBoMm0yIDBoMm0yIDBoMm0xIDBoMm0xIDBoM20yIDBoM00wIDExLjVoMW0zIDBoMm0xIDBoMW0yIDBoMW0yIDBoMm0xIDBoMW0xIDBoMm0xIDBoM20xIDBoMW0xIDBoMm0xIDBoM00wIDEyLjVoNG0yIDBoMW0xIDBoMm0xIDBoMW0zIDBoMm00IDBoMW0yIDBoMW0xIDBoM20zIDBoMU0wIDEzLjVoM200IDBoMW0yIDBoMW0xIDBoMm0xIDBoMW0xIDBoMW0zIDBoMW0xIDBoMW0xIDBoMW0xIDBoM20xIDBoMU0zIDE0LjVoNW0xIDBoMm0xIDBoMW0xIDBoMW01IDBoMW00IDBoMW0xIDBoMU0wIDE1LjVoMW0yIDBoMm0yIDBoMW00IDBoMm0xIDBoMm0xIDBoMW00IDBoM20xIDBoMW0xIDBoMU0wIDE2LjVoMW0xIDBoMW0yIDBoMm0xIDBoMm0yIDBoMm0xIDBoMm0xIDBoMW0xIDBoMW0yIDBoMW0xIDBoNk0wIDE3LjVoM20xIDBoMm01IDBoMm0yIDBoMW0zIDBoMm0xIDBoMW0xIDBoMW0xIDBoNE0yIDE4LjVoMW0xIDBoM203IDBoMW0xIDBoMm0yIDBoNG0xIDBoM20xIDBoNE0yIDE5LjVoMW0xIDBoMW0yIDBoMm0xIDBoMW0xIDBoMW0xIDBoMW0xIDBoNG0yIDBoM20xIDBoNk0wIDIwLjVoMm0xIDBoMm0xIDBoMW0xIDBoMm0xIDBoM201IDBoMW00IDBoMm0xIDBoMW0xIDBoMW0xIDBoMU0wIDIxLjVoMm0xIDBoMm0yIDBoMm0xIDBoMW0yIDBoMW0xIDBoMm0xIDBoM20xIDBoMW0yIDBoNk0wIDIyLjVoMW0xIDBoMW0xIDBoM20yIDBoNm0yIDBoMW0xIDBoMm0zIDBoMW0xIDBoM20xIDBoM00wIDIzLjVoMW0yIDBoMW0xIDBoMW02IDBoMm0yIDBoMW0xIDBoMW0xIDBoMW0xIDBoMW01IDBoMW0xIDBoMW0xIDBoMU0wIDI0LjVoMm00IDBoMW02IDBoMW0xIDBoMW0xIDBoNG0zIDBoNU04IDI1LjVoM20xIDBoMm0xIDBoMW0xIDBoMW0xIDBoMm0xIDBoMW0xIDBoMW0zIDBoNE0wIDI2LjVoN20xIDBoNG0xIDBoMm0xIDBoMW0xIDBoMW0yIDBoNG0xIDBoMW0xIDBoMW0xIDBoMU0wIDI3LjVoMW01IDBoMW0yIDBoMW02IDBoM20xIDBoMW0yIDBoMm0zIDBoMW0xIDBoMk0wIDI4LjVoMW0xIDBoM20xIDBoMW0xIDBoMW0zIDBoMW0zIDBoMm0zIDBoMW0xIDBoN20xIDBoMU0wIDI5LjVoMW0xIDBoM20xIDBoMW0xIDBoMW0yIDBoMW0zIDBoMW0zIDBoM20zIDBoMW0xIDBoMW0xIDBoM00wIDMwLjVoMW0xIDBoM20xIDBoMW0zIDBoMW0xIDBoM20yIDBoMm0xIDBoMW03IDBoMW0xIDBoM00wIDMxLjVoMW01IDBoMW0zIDBoM20yIDBoM20zIDBoMW04IDBoM00wIDMyLjVoN20yIDBoMW0yIDBoMW0yIDBoMm0yIDBoMW0xIDBoMW0xIDBoNG0xIDBoMyIvPjwvc3ZnPg=="
                    },
                    "link": "https://download.gerencianet.com.br/v1/30134_14_CORBO1/30134-14-SIRRA6?sandbox=true",
                    "billet_link": "https://visualizacaosandbox.gerencianet.com.br/emissao/30134_14_CORBO1/A4XB-30134-14-SIRRA6",
                    "pdf": {
                        "charge": "https://download.gerencianet.com.br/30134_14_CORBO1/30134-14-SIRRA6.pdf?sandbox=true"
                    },
                    "expire_at": "2022-08-23"
                }
            }*/
    }


}
