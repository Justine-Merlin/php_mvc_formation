<?php 

/**
 * Used to define the routes in the system.
 * 
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 * 
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
 */
$routes = array(
	'/test' => 'test#index',
	'/add/categorie' => 'application#addcateg',
	'/categories' => 'application#categories',
	'/films' => 'application#movies',
	'/add/categorie-update' => 'application#categorie',
	'/add/categorie-updated'=> 'ajax#updatecateg',
	'/add/film'=> 'application#addfilm',
	'/movie-update' => 'application#update_movie',
	'/movie-updated' => 'application#updated_movie',
	'/movie' => 'application#movie_details',
	'/ajaxsearchcategories'=> 'ajax#ajaxsearchcategories',
	'/ajaxresearchmovie'=> 'ajax#ajaxresearchmovie',
	'/inscription'=> 'user#inscription',
	'/login'=> 'user#login',
	'/deconnexion'=> 'user#deconnection',
	'/addbasket'=> 'ajax#addbasket',
	'/panier'=>'user#basket'
);
