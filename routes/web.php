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