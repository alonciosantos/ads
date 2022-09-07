<?php 

$routes->group('{locale}/dashboard', ['namespace' => 'App\Controllers\Dashboard', 'filter' => 'auth:web'], function ($routes){

    $routes->get('/', 'DashboardController::index', ['filter' => 'verified', 'as'=> 'dashboard']); // adicionar o apelido da rota 'as'
    $routes->get('my-plan', 'DashboardController::myPlan', ['as'=> 'my.plan']); 
    $routes->get('detail-charge/(:num)', 'DashboardController::detailCharge/$1', ['as'=> 'detail.charge']);     
    $routes->delete('cancel-subscription', 'DashboardController::cancelSubscription', ['as'=> 'my.subscription.cancel']); 
    $routes->get('confirm-deletion-account', 'DashboardController::confirmDeleteAccount', ['filter'=>'confirm','as'=> 'confirm.deletion.account']); 
    $routes->delete('deletion-account', 'DashboardController::accountDelete', ['as'=>'account.delete','filter'=>'confirm']); 
    
    $routes->get('profile', 'DashboardController::profile', ['filter' => 'confirm', 'as'=> 'profile']); // adicionar o apelido da rota 'as'
    $routes->put('profile-update', 'DashboardController::updateProfile', ['as'=> 'profile.update']); // adicionar o apelido da rota 'as'
    $routes->get('access', 'DashboardController::access', ['filter' => 'confirm', 'as'=> 'access']); // adicionar o apelido da rota 'as'
    $routes->put('access-update', 'DashboardController::updateAccess', ['as'=> 'access.update']); // adicionar o apelido da rota 'as'
    
    
    // Grupo User ads
     /**
     * @todo criar filtro subscription -- foi criado o filtro vamos usa-lo linha 23
     */

    $routes->group('adverts', ['namespace' => 'App\Controllers\Dashboard', 'filter'=>'subscription'], function ($routes){
       
        $routes->get('my', 'AdvertsUserController::index', ['as'=> 'my.adverts']);
        $routes->get('my-archived', 'AdvertsUserController::archived', ['as'=> 'my.archived.adverts']);
        $routes->get('my-pending-adverts', 'AdvertsUserController::pending', ['as'=> 'my.pending.adverts']);
        $routes->get('get-all-my-adverts-nopublished', 'AdvertsUserController::getUserAdvertsNoPublished', ['as'=> 'get.all.my.adverts.nopublished']);
        
        $routes->get('get-all-my-adverts', 'AdvertsUserController::getUserAdverts', ['as'=> 'get.all.my.adverts']);
        $routes->get('get-all-my-achived-adverts', 'AdvertsUserController::getUserArchivedAdverts', ['as'=> 'get.all.my.archived.adverts']);
        $routes->get('get-my-advert', 'AdvertsUserController::getUserAdvert', ['as'=> 'get.my.advert']);
        $routes->get('get-categories-situations', 'AdvertsUserController::getCategoriesAndSituations', ['as'=> 'get.categories.situations']);
        $routes->get('edit-images/(:num)', 'AdvertsUserController::editUserAdvertImages/$1', ['as'=> 'adverts.my.edit.images']);
        $routes->post('create', 'AdvertsUserController::createUserAdvert', ['as'=> 'adverts.create.my', 'filter'=>'adverts']); 
        $routes->put('update', 'AdvertsUserController::updateUserAdvert', ['as'=> 'adverts.update.my']);
        $routes->put('upload/(:num)', 'AdvertsUserController::uploadAdvertImages/$1', ['as'=> 'adverts.upload.my']);
        $routes->put('archive', 'AdvertsUserController::archiveUserAdvert', ['as'=> 'adverts.archive.my']);
        $routes->put('recover', 'AdvertsUserController::recoverUserAdvert', ['as'=> 'adverts.recover.my']);
        $routes->delete('delete', 'AdvertsUserController::deleteUserAdvert', ['as'=> 'adverts.delete.my']);
        $routes->delete('delete-image/(:any)', 'AdvertsUserController::deleteUserAdvertImage/$1', ['as'=> 'adverts.delete.image']);
        


        //Perguntas e respostas
        
        $routes->get('questions/(:any)', 'AdvertsUserController::UserAdvertQuestions/$1', ['as'=> 'adverts.my.edit.questions']);
        $routes->put('answer/(:num)', 'AdvertsUserController::UserAdvertAnswerQuestions/$1', ['as'=> 'adverts.my.answer.questions']);
    });
});
