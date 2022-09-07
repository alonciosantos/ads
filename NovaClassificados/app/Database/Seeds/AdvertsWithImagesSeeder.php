<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdvertsWithImagesSeeder extends Seeder
{
    public function run()
    {
        try {
            $this->db->transStart();
            $this->db->disableForeignKeyChecks();

            foreach (self::adverts() as $advert) {
                $this->db->table('adverts')->insert($advert);
            }

            foreach (self::images() as $image) {
                $this->db->table('adverts_images')->insert($image);
            }

            $this->db->enableForeignKeyChecks();
            //print_r(self::subscriptions());
            // exit;
            $this->db->transComplete();

            echo 'Users criadas com sucesso!';
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            print $th;
        }
    }

    private static function adverts(): array
    {

        $adverts = array(
            array('id' => '15', 'user_id' => '9', 'category_id' => '34', 'code' => 'ADVERT_63024FDFB21363.95704851', 'title' => 'cristiano47', 'description' => 'Era preciso uma somma que pagasse os atrazados todos. Deus podia muito bem, irritado com os melhores de outras terras. A medicina é uma santa, seu tio é um simples aggregado... Geitoso é, póde muito bem servir a Deus que a familia Padua perdeu tanta cousa; d\'ahi vieram as nossas relações. Pois eu hei de confessar á minha gente esta miseria. E os discursos que elle seja o que lhe desciam á cintura. Em pé não dava geito: não esquecestes que ella manda; estou prompto a ser padre._ Conheci aqui o.', 'price' => '673.97', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '30502-645', 'street' => 'Largo Eunice', 'number' => '19899', 'neighborhood' => 'Vila Agatha do Norte', 'city' => 'Santa Dirce', 'city_slug' => 'santa-dirce', 'state' => 'SC', 'created_at' => '2022-08-21 12:31:43', 'updated_at' => '2022-08-21 12:31:43', 'deleted_at' => NULL),
            array('id' => '170', 'user_id' => '8', 'category_id' => '5', 'code' => 'ADVERT_63024FDFEF1C26.59688511', 'title' => 'pena.jennifer', 'description' => 'Rio de Janeiro com a indignação que experimentei, rompesse a chamar-lhe beata e carola, em voz tão alta que eu, mas ainda que quizesse, faltava-me lingua. Preso, atordoado, não achava bonito o perfil de Cesar, mas as acções citadas por José Dias lhe poz. Ninguem lhe chamava assim lá em casa; era só alguma ausencia, por causa dos estudos; só os primeiros dias. Em pouco tempo eu me acostumaria aos companheiros e aos mestres, e acabaria gostando de viver com elles. --Eu só gosto de mamãe. Não.', 'price' => '162.81', 'is_published' => '0', 'situation' => 'used', 'zipcode' => '53404-996', 'street' => 'Avenida Roberta', 'number' => '96', 'neighborhood' => 'Mia do Leste', 'city' => 'Rosa do Sul', 'city_slug' => 'rosa-do-sul', 'state' => 'RO', 'created_at' => '2022-08-21 12:31:43', 'updated_at' => '2022-08-21 12:31:43', 'deleted_at' => NULL),
            array('id' => '219', 'user_id' => '11', 'category_id' => '25', 'code' => 'ADVERT_63024FE00BED10.14790555', 'title' => 'mendes.regiane', 'description' => 'Capitú... Sentia-os estirados, embaixo dos meus, egualmente esticados para os seus, o amor que tinha ao outro, teimava em dizer que conferia, rotulava e pregava na memoria a minha mãe, tudo isto me accendeu a ponto de elogial-a tambem. Quando não era nada, maluquices da filha. Olhava com ternura para mim e escanchou-me em cima do selim. Raramente a besta deixava de mostrar por um modo de roer o roido. XVIII Um plano. Pae nem mãe foram ter comnosco, quando Capitú e eu. Ella servia de sacristão.', 'price' => '418.98', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '32272-548', 'street' => 'Rua Casanova', 'number' => '7', 'neighborhood' => 'Edson do Leste', 'city' => 'São Allison do Leste', 'city_slug' => 'sao-allison-do-leste', 'state' => 'SP', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 12:31:44', 'deleted_at' => NULL),
            array('id' => '222', 'user_id' => '5', 'category_id' => '56', 'code' => 'ADVERT_63024FE00CB115.37273309', 'title' => 'Tênis Adidas Runfalcon 2.0 Masculino - Preto+Branco', 'description' => 'Indicado para: Dia a Dia
          Material: Mesh
          Categoria: Amortecimento
          Composição: Cabedal: Tripla camada de Mesh. Calcanhar acolchoado e fecho em cadarço; Entressola: EVA; Solado: Borracha
          Pisada: Neutra
          Garantia do Fabricante: Contra defeito de fabricação', 'price' => '229.39', 'is_published' => '0', 'situation' => 'new', 'zipcode' => '64040-690', 'street' => 'Rua Nossa Senhora do Rosário', 'number' => '15', 'neighborhood' => 'Angelim', 'city' => 'Teresina', 'city_slug' => 'teresina', 'state' => 'PI', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 14:06:00', 'deleted_at' => NULL),
            array('id' => '290', 'user_id' => '4', 'category_id' => '57', 'code' => 'ADVERT_63024FE027E5B0.92698842', 'title' => 'Camisa Masculina Lisa', 'description' => 'Camisa Masculina Lisa, produzida em alta qualidade e feita em malha Cacharrel, pode ser usada no dia a dia ou para pratica de esportes, compre no atacado para revenda.
          Tamanhos: M ( Veste entre 36 ao 40)
          Cores: preto, azul, bege, rosa entre outras cores
          Modelo: Camisa Masculina Lisa
          Material: Cacharrel 100% poliester', 'price' => '32.99', 'is_published' => '0', 'situation' => 'new', 'zipcode' => '64212-363', 'street' => 'Travessa São Tomé', 'number' => '7', 'neighborhood' => 'Alto Santa Maria', 'city' => 'Parnaíba', 'city_slug' => 'parnaiba', 'state' => 'PI', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 13:57:58', 'deleted_at' => NULL),
            array('id' => '335', 'user_id' => '15', 'category_id' => '48', 'code' => 'ADVERT_63024FE03991A8.75519718', 'title' => 'miranda.fonseca', 'description' => 'Tambem se descompunha em accionados, era muita vez toda a gente do Padua? --Ha algum tempo estou para lhe dizer que foram criados juntos, desde aquella grande enchente, ha dez annos, em que meu pae já não podia dispensal-o. Tinha o dom de se lhe salvava o marido que se estenderam pouco a pouco, e a filha... Padua obedeceu; confessou que certamente não era medico. Tomára este titulo para a Europa. Dito isto, espreitou-me os olhos, metteu-os em si mesma; complicada da lembrança de minha mãe, não.', 'price' => '740.54', 'is_published' => '0', 'situation' => 'used', 'zipcode' => '65436-570', 'street' => 'Rua Joaquim Salas', 'number' => '2', 'neighborhood' => 'Michael do Norte', 'city' => 'Santa Yuri', 'city_slug' => 'santa-yuri', 'state' => 'RN', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 12:31:44', 'deleted_at' => NULL),
            array('id' => '359', 'user_id' => '2', 'category_id' => '57', 'code' => 'ADVERT_63024FE0422458.38389988', 'title' => 'Camisa gola Careca Manga Longa Masculina', 'description' => 'Camisa gola Redonda Manga Longa Masculina
          TECIDO: malha PV. (75% Poliéster/25% Viscose)
          TAMANHO:
          M G GG
          CORES: VARIADOS
          MODELO: Camisa manga longa
          PÚBLICO: Bom Acabamento', 'price' => '39.99', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '64058-316', 'street' => 'Rua Bitar', 'number' => '7', 'neighborhood' => 'Samapi', 'city' => 'Teresina', 'city_slug' => 'teresina', 'state' => 'PI', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 13:06:43', 'deleted_at' => NULL),
            array('id' => '375', 'user_id' => '4', 'category_id' => '57', 'code' => 'ADVERT_63024FE046A994.33026150', 'title' => 'Camisa Gola Polo Masculina com Ziper', 'description' => 'Camisa Gola Polo Com Ziper Masculina  de poliéster 
          TECIDO: Malha PP 100% poliéster 
          TAMANHOS: M 
          CORES: VARIADAS
          MODELO : polo com ziper', 'price' => '25.00', 'is_published' => '0', 'situation' => 'new', 'zipcode' => '64212-363', 'street' => 'Travessa São Tomé', 'number' => '7', 'neighborhood' => 'Alto Santa Maria', 'city' => 'Parnaíba', 'city_slug' => 'parnaiba', 'state' => 'PI', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 13:55:29', 'deleted_at' => NULL),
            array('id' => '398', 'user_id' => '4', 'category_id' => '58', 'code' => 'ADVERT_63024FE0501D93.88437493', 'title' => 'Bermuda Jeans Masculina Lycra', 'description' => 'Bermuda Jeans Masculina Lycra, lindo modelo temos dois modelos para voce escolher e colocar na sua loja para revenda, modelo desdoyed e com um bordado que da um detalhe e facilida a sua venda. compre para revenda no atacado.
           Tecido: Jeans
          Tamanho: 36 AO 44
          Cores: Variadas
          Modelo : compre no atacado e revenda essa Bermuda Jeans Masculina Lycra na sua loja.', 'price' => '78.79', 'is_published' => '0', 'situation' => 'new', 'zipcode' => '64212-363', 'street' => 'Travessa São Tomé', 'number' => '7', 'neighborhood' => 'Alto Santa Maria', 'city' => 'Parnaíba', 'city_slug' => 'parnaiba', 'state' => 'PI', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 13:52:47', 'deleted_at' => NULL),
            array('id' => '651', 'user_id' => '11', 'category_id' => '16', 'code' => 'ADVERT_63024FE0B44F32.21487280', 'title' => 'quintana.willian', 'description' => 'Vi-lhe fazer um vestido de chita, e a Casa de Correcção. Todas essas bellas instituições sociaes me envolviam no seu mysterio, sem que os della eram muito mais que os olhos tres ou quatro vezes minha mãe ter conhecido outr\'ora meninos muito intelligentes, mas que a sacudi brandamente. Capitú tornou ao que era, sacudia-me com brandura, levantava-me o queixo e espetava os olhos para elles, e esqueço os bilhetes brancos e a infancia e a Paulo o que é a verdade, e, para dizer o que se passára com.', 'price' => '641.79', 'is_published' => '0', 'situation' => 'new', 'zipcode' => '53913-042', 'street' => 'Rua Marés', 'number' => '6527', 'neighborhood' => 'Santa Renan d\'Oeste', 'city' => 'Aguiar d\'Oeste', 'city_slug' => 'aguiar-doeste', 'state' => 'CE', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 12:31:44', 'deleted_at' => NULL),
            array('id' => '679', 'user_id' => '7', 'category_id' => '28', 'code' => 'ADVERT_63024FE0BEAC49.31460721', 'title' => 'olga.carmona', 'description' => 'O padre Cabral foi porque o padre, que lavava as mãos. Depois, como Padua falasse ao sacristão, baixinho, approximou-se delles; eu fiz a mesma cabeça, os mesmos lances se reproduzam, sem razao sufficiente. Certos motivos cançam á força de repetição. Tambem ha obscuridades; o maestro abusa das massas choraes, encobrindo muita vez a alma.... XXI Prima Justina. Na varanda achei prima Justina, passeando de um grande riso sem vontade, mas communicativo, a tal titulo, deu-me vontade de servir é.', 'price' => '435.48', 'is_published' => '1', 'situation' => 'new', 'zipcode' => '35779-520', 'street' => 'Rua Luciana', 'number' => '682', 'neighborhood' => 'Vila Evandro', 'city' => 'Gean d\'Oeste', 'city_slug' => 'gean-doeste', 'state' => 'SE', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 12:31:44', 'deleted_at' => NULL),
            array('id' => '699', 'user_id' => '4', 'category_id' => '58', 'code' => 'ADVERT_63024FE0C797A4.75042435', 'title' => 'Bermuda Tactel masculina Lisa', 'description' => 'Bermuda Tactel masculina Lisa
          Com essa Bermuda Tactel masculina Lisa moda praia, moda verao usa no dia a dia, basico voce pode vender para a sua loja num otimo preço. compre hoje mesmo para revenda atacado.
          MATERIAL:
          Tactel - 100% Poliester
          TAMANHO:
          36/38/40/42/44
          CORES/ESTAMPAS:
          enviamos sortidos conforme a disponibilidade no estoque.
          MODELOS:
          Bermuda Tactel masculina Lisa compre pra revenda.', 'price' => '25.99', 'is_published' => '0', 'situation' => 'new', 'zipcode' => '64212-363', 'street' => 'Travessa São Tomé', 'number' => '7', 'neighborhood' => 'Alto Santa Maria', 'city' => 'Parnaíba', 'city_slug' => 'parnaiba', 'state' => 'PI', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 13:49:33', 'deleted_at' => NULL),
            array('id' => '702', 'user_id' => '12', 'category_id' => '21', 'code' => 'ADVERT_63024FE0C8A6C3.99632242', 'title' => 'noa.abreu', 'description' => 'Preso, atordoado, não achava bonito o perfil de Cesar, mas as acções citadas por José Dias veiu a alegria, um domingo, na figura de pau. Quiz chamal-a, sacudil-a, mas faltou-me animo. Essa creatura que brincára commigo, que pulára, dansára, creio até que dormira commigo, deixava-me agora com os braços caíam-me, felizmente a casa em que tempo será elle demolido por utilidade astronomica. O exito é crescente. Poeta e musico recebem pontualmente os seus no chão. Não era o meu nome ligado a tal.', 'price' => '999.47', 'is_published' => '0', 'situation' => 'used', 'zipcode' => '34823-934', 'street' => 'Largo Azevedo', 'number' => '64077', 'neighborhood' => 'Nayara d\'Oeste', 'city' => 'Porto Amanda do Sul', 'city_slug' => 'porto-amanda-do-sul', 'state' => 'PI', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 12:31:44', 'deleted_at' => NULL),
            array('id' => '707', 'user_id' => '11', 'category_id' => '52', 'code' => 'ADVERT_63024FE0CAAEF5.87243283', 'title' => 'ndeverso', 'description' => 'A voz, um tanto remoto, mas eu pensei em fazer uma saude, os olhos humidos. Disse-lhe que tambem gostava de mim, e, não querendo interrogal-a novamente, entrei a gritar desesperadamente: «Mamãe! mamãe!» Ella acudiu pallida e tremula, cuidou que me restam são de data recente; todos os diabos. Trocava passaros com outros amadores, comprava-os, apanhava alguns, no proprio quintal, armando alçapões. Tambem, se adoeciam, tratava delles como se não approvava a minha amiga; pensei nisso, cheguei a.', 'price' => '823.76', 'is_published' => '0', 'situation' => 'used', 'zipcode' => '43634-068', 'street' => 'R. Paes', 'number' => '16537', 'neighborhood' => 'Arruda do Leste', 'city' => 'de Oliveira do Norte', 'city_slug' => 'de-oliveira-do-norte', 'state' => 'ES', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 12:31:44', 'deleted_at' => NULL),
            array('id' => '733', 'user_id' => '7', 'category_id' => '18', 'code' => 'ADVERT_63024FE0D5FFC9.40058061', 'title' => 'ljimenes', 'description' => 'Mas essas pedem um capitulo especial. Rematemos este dizendo que os meus; eu, depois de alguns officios rudes, eram curadas com amor; não cheiravam a sabões finos nem aguas de toucador, mas com agua do poço e sabão commum trazia-as sem macula. Calçava sapatos de verniz. Viveu assim vinte e dous annos de edade poderia enganar os extranhos, como todos os meus projectos de resistencia franca, fosse antes pelos meios brandos, pela acção do tempo. Vivia mettida em um vestido de chita, veste caseira.', 'price' => '56.26', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '98047-796', 'street' => 'Largo Lozano', 'number' => '1939', 'neighborhood' => 'Santa Henrique do Norte', 'city' => 'Vila Sônia', 'city_slug' => 'vila-sonia', 'state' => 'RR', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 12:31:44', 'deleted_at' => NULL),
            array('id' => '743', 'user_id' => '6', 'category_id' => '28', 'code' => 'ADVERT_63024FE0D95A01.60115368', 'title' => 'maya.avila', 'description' => 'Bentinho, suspirou o pae de Capitú. Foi nessa occasião que minha mãe era boa creatura. Quando lhe disse que falaria ao aggregado. Formulei o pedido de cabeça, escolhendo as palavras de Capitú com infinito prazer. --Obrigado, Capitú, muito obrigado; estimo que você fez promessa... mas, uma promessa de minha mãe, e disse delle cousas feias e duras. Capitú reflectiu algum tempo, e já agora póde haver uma difficuldade. --Que difficuldade? --Uma grande difficuldade. Minha mãe assoou-se sem.', 'price' => '467.16', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '35653-610', 'street' => 'Travessa Guerra', 'number' => '474', 'neighborhood' => 'Feliciano d\'Oeste', 'city' => 'Vila Ícaro', 'city_slug' => 'vila-icaro', 'state' => 'AP', 'created_at' => '2022-08-21 12:31:44', 'updated_at' => '2022-08-21 12:31:44', 'deleted_at' => NULL),
            array('id' => '814', 'user_id' => '10', 'category_id' => '14', 'code' => 'ADVERT_63024FE10184E7.24010743', 'title' => 'psantiago', 'description' => 'Tinha-os de varia especie, côr e a orchestração é excellente... --Mas, meu caro Marcolini... --Quê...? E, depois de muito merecimento; descontai-me a edade e da nossa separação, como de um grande collar, um diadema e brincos. --São joias viuvas, como eu, Capitú. --Quando é que já terão padecido no inferno os seus conselhos, não é? Tio Cosme respondeu com uma grande sciencia; basta só isto de dar um capote ao doutor, mas não me attendeu. XLIV O primeiro filho. --Dê cá, deixe escrever uma cousa.', 'price' => '726.79', 'is_published' => '1', 'situation' => 'new', 'zipcode' => '55616-477', 'street' => 'Largo Vale', 'number' => '57', 'neighborhood' => 'Vila Jácomo do Sul', 'city' => 'São Gabriela d\'Oeste', 'city_slug' => 'sao-gabriela-doeste', 'state' => 'DF', 'created_at' => '2022-08-21 12:31:45', 'updated_at' => '2022-08-21 12:31:45', 'deleted_at' => NULL),
            array('id' => '844', 'user_id' => '10', 'category_id' => '39', 'code' => 'ADVERT_63024FE10C9A50.48261110', 'title' => 'lfeliciano', 'description' => 'Antes de sair, voltou-se para mim, dizia-me, cheio de ternura: --Quem dirá que esta razão accendeu nella o desejo de o trazer. Conto estas minucias para que melhor podia fazer, sem latim, e até com latim. Ao cabo de um facto certo e definitivo, por mais que a fez molesta, e, de memoria, e estremecer quando lhe ouvia os passos. Se se falava nella, em minha presença, que o joven Satanaz compoz a grande opera, nem essa farça nem Shakespeare eram nascidos. Chegam a affirmar que o pungiu foi.', 'price' => '517.03', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '56461-569', 'street' => 'Rua Wesley', 'number' => '77', 'neighborhood' => 'Santa Madalena', 'city' => 'Ferminiano d\'Oeste', 'city_slug' => 'ferminiano-doeste', 'state' => 'RN', 'created_at' => '2022-08-21 12:31:45', 'updated_at' => '2022-08-21 12:31:45', 'deleted_at' => NULL),
            array('id' => '860', 'user_id' => '6', 'category_id' => '26', 'code' => 'ADVERT_63024FE1128214.18023131', 'title' => 'xescobar', 'description' => 'Era a primeira que lhe chamassem o protonotario Cabral. --Mas, Sr. José Dias, meu caro Marcolini... --Quê...? E, depois de muito examinar... --Em todo caso, entenderia. Mas aquella pergunta assim, vaga e solta, não pude atinar o que me vexa imprimil-o, mas vá lá. Um dia, Capitú quiz que prima Justina achou no espectaculo das sensações alheias uma resurreição vaga das proprias. Tambem se goza por influição dos labios que narram. XXIII Prazo dado. --Preciso falar-lhe amanhã, sem falta; escolha o.', 'price' => '719.17', 'is_published' => '0', 'situation' => 'used', 'zipcode' => '81063-418', 'street' => 'Avenida Lorena Gonçalves', 'number' => '485', 'neighborhood' => 'Vila Michelle do Sul', 'city' => 'Porto Eric do Norte', 'city_slug' => 'porto-eric-do-norte', 'state' => 'SP', 'created_at' => '2022-08-21 12:31:45', 'updated_at' => '2022-08-21 14:19:51', 'deleted_at' => NULL),
            array('id' => '878', 'user_id' => '13', 'category_id' => '14', 'code' => 'ADVERT_63024FE1189913.07670561', 'title' => 'defreitas.mauricio', 'description' => 'Não é que Capitú não me occorria nada entre nós que fosse separação; era só o tempo. Você ainda era pequenino, já ella contava a denuncia do meu procedimento podiam ser e eram patricios de Poncio Pilatos. Não nego que o verso vae para a minha amiga; pensei nisso, cheguei a escrever o livro. Antes disso, porém, digamos os motivos della, cousas que não era má, e eu podia excusar o extraordinario da aventura. Como vês, Capitú, aos quatorze annos, tinha já ideias atrevidas, muito menos que as.', 'price' => '760.29', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '21169-787', 'street' => 'Av. Bruno Escobar', 'number' => '218', 'neighborhood' => 'Vila Sebastião', 'city' => 'Aurora d\'Oeste', 'city_slug' => 'aurora-doeste', 'state' => 'AP', 'created_at' => '2022-08-21 12:31:45', 'updated_at' => '2022-08-21 12:31:45', 'deleted_at' => NULL),
            array('id' => '891', 'user_id' => '11', 'category_id' => '32', 'code' => 'ADVERT_63024FE11D1962.32482365', 'title' => 'mmarinho', 'description' => 'Padre que seja, se fôr vigario na roça, é preciso que monte a cavallo; e, aqui mesmo, ainda não sendo padre, se quizer florear como os outros sonhos, tecem-se pelo desenho das nossas inclinações e das cousas que me houvesse deitado ao chão; mas o principal não é alcançar. Anjo do meu intento; imaginou que era um elogio. XXV No Passeio Publico. Algumas caras velhas, outras doentes ou só agradeceram a boa intenção. Com effeito, ha logares em que ella emendou logo a antiga intimidade, mas esta.', 'price' => '133.10', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '53313-456', 'street' => 'Travessa Luna das Neves', 'number' => '610', 'neighborhood' => 'Cristóvão do Leste', 'city' => 'Pedrosa do Leste', 'city_slug' => 'pedrosa-do-leste', 'state' => 'RN', 'created_at' => '2022-08-21 12:31:45', 'updated_at' => '2022-08-21 12:31:45', 'deleted_at' => NULL),
            array('id' => '902', 'user_id' => '3', 'category_id' => '58', 'code' => 'ADVERT_63024FE1215998.28321746', 'title' => 'Bermuda Masculina Básica Em Algodão', 'description' => 'Bermuda Masculina Básica Em Algodão
          Bermuda Masculina Básica Em Algodão, é um produto de uso casual, pois trás conforto e comodidade, seu tecido brim 100% algodão é de ótima qualidade, textura fino, não transparente, tem cós de elastico com regulador na cintura, não pode faltar na sua loja. Compre para revenda.
          TECIDO: Brim
          Composição: 100% Algodão
          TAMANHOS: P M G 
          CORES: VARIADAS ', 'price' => '39.00', 'is_published' => '0', 'situation' => 'new', 'zipcode' => '64218-170', 'street' => 'Rua Paulino Bastos', 'number' => '8276', 'neighborhood' => 'São José', 'city' => 'Parnaíba', 'city_slug' => 'parnaiba', 'state' => 'PI', 'created_at' => '2022-08-21 12:31:45', 'updated_at' => '2022-08-21 13:44:46', 'deleted_at' => NULL),
            array('id' => '956', 'user_id' => '11', 'category_id' => '21', 'code' => 'ADVERT_63024FE13528A6.48925611', 'title' => 'solano.violeta', 'description' => 'No painel parece offerecer a flôr ao marido. O que eu conhecesse o texto, as attitudes de Capitú fechava-me os labios. Uma exclamação, um simples artigo, por mais que a obra é sua. Ha livros que estás estudando; é bonito, não só me espiava do chão com gesto escarninho, mas até me pareceu que repercutia no ar. Tive então uma ideia fantastica, a ideia da egreja; brincos de creança, livros devotos, imagens de santos, conversações de casa, cosido á parede, e vi-o passar com as duas tranças. Onde.', 'price' => '852.87', 'is_published' => '1', 'situation' => 'used', 'zipcode' => '60835-888', 'street' => 'Rua Mônica Velasques', 'number' => '54738', 'neighborhood' => 'Porto Ronaldo', 'city' => 'Porto Hernani do Norte', 'city_slug' => 'porto-hernani-do-norte', 'state' => 'MG', 'created_at' => '2022-08-21 12:31:45', 'updated_at' => '2022-08-21 12:31:45', 'deleted_at' => NULL),
            array('id' => '965', 'user_id' => '7', 'category_id' => '42', 'code' => 'ADVERT_63024FE138BC04.64299488', 'title' => 'alicia.mendonca', 'description' => 'Passeio, um mendigo estendeu-nos a mão. Então o imperador apeava-se e entrava. Grande alvoroço na visinhança: «O imperador entrou em casa quem lhe vestia e despia a toga, com muitos comprimentos no fim. --Acho que nenhum; foi só maluquice; até logo. --Como até logo? --Está-me voltando a mim e escanchou-me em cima do quintal e foram para os lados do morro de Santa Rita, teimou com meu pae foi eleito deputado e veiu para o ceu. O ceu estava coberto. Capitú falou novamente da nossa casa, velho.', 'price' => '859.39', 'is_published' => '0', 'situation' => 'used', 'zipcode' => '19929-879', 'street' => 'R. Dominato', 'number' => '70', 'neighborhood' => 'Santa Camila d\'Oeste', 'city' => 'Diana do Leste', 'city_slug' => 'diana-do-leste', 'state' => 'PA', 'created_at' => '2022-08-21 12:31:45', 'updated_at' => '2022-08-21 12:31:45', 'deleted_at' => NULL),
        );

        return $adverts;
    }

    private static function images(): array
    {

        $advertsImages = array(
            array('id' => '7', 'adverts_id' => '359', 'image' => '1661097953_c45fb923c9c2ad34213d.jpg'),
            array('id' => '8', 'adverts_id' => '359', 'image' => '1661098003_06f7a37e7561e2fbfccb.jpg'),
            array('id' => '9', 'adverts_id' => '359', 'image' => '1661098003_ccc74703e1dbe272a7a6.jpg'),
            array('id' => '10', 'adverts_id' => '902', 'image' => '1661100188_c3ccec82cc3799418676.jpg'),
            array('id' => '11', 'adverts_id' => '902', 'image' => '1661100188_118e9db6a88724351346.jpg'),
            array('id' => '12', 'adverts_id' => '902', 'image' => '1661100188_c67d3fd77bc9ff2e40ae.jpg'),
            array('id' => '13', 'adverts_id' => '902', 'image' => '1661100188_3f2b4b0c52a8a5615fd3.jpg'),
            array('id' => '14', 'adverts_id' => '699', 'image' => '1661100572_5fffdbfc03fefee0ebe8.jpg'),
            array('id' => '15', 'adverts_id' => '699', 'image' => '1661100572_7e030ec819cb2ef14139.jpg'),
            array('id' => '16', 'adverts_id' => '699', 'image' => '1661100573_a04e7afe825447cb263f.jpg'),
            array('id' => '17', 'adverts_id' => '699', 'image' => '1661100573_b77d540d63d5ae3f6c01.jpg'),
            array('id' => '18', 'adverts_id' => '398', 'image' => '1661100767_a3b40f9357a6b868865b.jpg'),
            array('id' => '19', 'adverts_id' => '398', 'image' => '1661100767_2f89f35efb89eaf31684.jpg'),
            array('id' => '20', 'adverts_id' => '398', 'image' => '1661100767_e7a4fde759074ce02b4d.jpg'),
            array('id' => '21', 'adverts_id' => '398', 'image' => '1661100767_60c014fb3fe7511a3ee9.jpg'),
            array('id' => '22', 'adverts_id' => '375', 'image' => '1661100929_b1e0818030305aec473e.jpg'),
            array('id' => '23', 'adverts_id' => '375', 'image' => '1661100929_ed6254c644c7ccabd704.jpg'),
            array('id' => '24', 'adverts_id' => '375', 'image' => '1661100929_954d9c38861aaca5bbbc.jpg'),
            array('id' => '25', 'adverts_id' => '290', 'image' => '1661101078_142f841307f2e1b4764c.jpg'),
            array('id' => '26', 'adverts_id' => '290', 'image' => '1661101078_5cc24c9c0d5b8e1c21c6.jpg'),
            array('id' => '27', 'adverts_id' => '222', 'image' => '1661101438_ceaed43a06418386cb11.webp'),
            array('id' => '28', 'adverts_id' => '860', 'image' => '1661102391_5c6ca9f7949474798211.webp')
        );


        return $advertsImages;
    }
}
