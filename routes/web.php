<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return 'Bienvenue chez Bonjour Taxi';
});

Route::get('accueil', function(){
    return 'Bienvenue chez bonjour taxi';
});

Route::get('a-propos', function(){
    return 'Bonjour Taxi est une start-up disruptive';
});

Route::get('tarifs/pro', function(){
    if(session()->get('currency') == ('euro')) {
        $tarif = "10€";
    }else{
        $tarif = "15 $";
    }
    return "$tarif par mois pour les pros";
    });

Route::get('tarifs/particuliers', function(){
    return 'gratuit pour les particuliers';
});

Route::get('recettes/{id}', function($id){ //transmettre des paramètres page 58
    $recipe = get_recipe($id); // on imagine une fonction get_recipe
    return "texte de la recette " . $recipe->text; //affichage du texte des recettes via une méthode text imaginative
});


//envoyer deux paramètres à la requête p58
Route::get('recettes/{recette-id}/commentaire/{comment-id}',function($recetteid, $commentid){
    $response = "recette numéro $recetteid \n"; //initialisation de la variable $response
    $response.= "Commentaire numéro $commentid \n"; // concaténation de la variable $response
    return $response; 
    // affichera recette numéro 5
    // Commentaire numéro 5
});

//paramètres optionnels p59
Route::get('bonjour/{name?}', function ($name = null) { //le ? rend le paramètre optionnel
    if ($name === null) {
        return 'Bonjour tout le monde'; // si déclaré affiche Bonjour tout le monde
    }else{
        return 'Bonjour ' . $name;
    }
});

//retour des réponses via des paramètres source: https://developer.mozilla.org/fr/docs/Web/HTTP/Headers
//cette route permet de renvoyer une réponse sur mesure avec les en-têtes HTTP
Route::get('accueil', function(){
    return response('Bienvenue sur le site', 200) //renvoi le statut 200 donc OK
        ->header('Content-Type', 'text/plain') // renvoi un content type texte
        ->header('Pragma','no-cache') // pas de cache
        ->header(
            'Cache-Control',
            'no-cache,no-store,must-revalidate'
        );
});

//les réponses en JSON très utile pour créer une api
Route::get('produits/{id}', function($id){
    $p = get_product($id); // la fonction get_product retourne un objet de type Product
    return response()->json($p); //ici on retourne la méthode get_product avec du JSON
    //on recevra en appelant l'adresse /produits/123
    // {"id": 123, "name" = "parfum x", "price": 255}
});


//pour faire des redirections 
//par exemple sur une page obsolète
Route::get('ancienne', function(){ // ceci est l'ancienne page qui redirige vers la route nouvelle
    return redirect('nouvelle');
});

Route::get('nouvelle', function(){
    return "Vous êtes sur la nouvelle page !";
});

//pour rediriger l'utilisateur vers les pages précédentes
//instruction
//              return redirect()->back();


//les préfixes de routes on peut grouper les routes quand nous avons 
// un grand nombre de routes comme avec un admin
Route::prefix('admin')->group (function(){
    Route::get('stats', function(){/*...*/});
    Route::get('user', function(){/*...*/});
    Route::get('user/{id}', function($id){/*...*/});
});

//les sous-domaines //source https://laravel.com/docs/8.x/routing#route-group-subdomain-routing
Route::domain('{client}.auto-ecole.com')->group(function () {
    Route::get('/', function($client){
        return "Accueil de l'auto école $client.";
    });
    Route::get(’/’, function ($client) {  
        return "Accueil de l’auto-école $client.";  
    });  
    Route::get(’planning’, function ($client) {  
        return "Planning de l’auto-école $client.";  
    });
    Route::get('planning', function($client){
        return "Planning de l'auto école $client";
    });
});

//on peut aussi prefixer les routes avec des nom de routes ensuite
Route::name('admin')->group(function (){
    Route::get('users', function() {
        //route assigned name "admin.users"...
    })->name('users');
});