<?php

namespace LidemFramework;

use Laminas\Diactoros\Response\HtmlResponse;
use LidemFramework\Exception\ViewInvalidNameException;
use Psr\Http\Message\ResponseInterface;

class View
{
	public const VIEW_PATH = APP_ROOT_PATH .'views'. DS;
	public const ERROR_PATH = self::VIEW_PATH .'_error'. DS;
	public const PARTIAL_PATH = self::VIEW_PATH .'_partial'. DS;

	private string $path;
	private bool $is_partial;

	public static function ErrorResponse( int $status_code, array $view_data = [] ): ResponseInterface
	{
		// Démarrage de la mise en cache de la réponse (object buffer)
		// Après cette toute action qui ajoute du contenu à la réponse
		// (echo, include, require, etc.) sera préenregistrée dans la mémoire
		ob_start();

		// Extraction des données de la vue
		// Recrée des variables à partir d'un tableau associatif
		// exemple: [ 'toto' => 4, 'tutu' => 12 ]
		// après extract() on aura le même résultat que si on avait tapé
		// $toto = 4; $tutu = 12
		extract( $view_data );

		// Gestion spéciale pour le code 404
		if( $status_code === 404 ) {
			require_once self::PARTIAL_PATH. '_header.phtml';
			require_once self::ERROR_PATH. '_404.phtml';
			require_once self::PARTIAL_PATH. '_footer.phtml';
		}
		else {
			require_once self::ERROR_PATH. $status_code. '.phtml';
		}

		// On récupère le contenu du cache sous forme de string tout en le vidant (ce qui libère la mémoire)
		$ob_result = ob_get_clean();

		return new HtmlResponse( $ob_result, $status_code );
	}

	/**
	 * @throws ViewInvalidNameException
	 */
	public function __construct( string $view_name, bool $is_partial = true )
	{
		$this->is_partial = $is_partial;

		// On considère que le nom de la vue est de la forme "dossier/nom"
		// par exemple pour le fichier _home.phtml, le nom serait "page/home"
		// le mode "partial" donné en argument permet d'ajouter "_" ou non

		// preg_match teste le nom donné selon le format décidé
		// Les parenthèses dans la regex permettent au passage de récupérer les infos de chaque
		// côté du "/"
		// preg_match retourne 1 si le test est bon, sinon 0
		$is_valid = preg_match( '/^([a-z0-9]+)\/([a-z0-9]+)$/', $view_name, $matches ) > 0;

		if( ! $is_valid ) {
			throw new ViewInvalidNameException();
		}

		$this->path = self::VIEW_PATH. $matches[1] .DS;

		if( $this->is_partial ) {
			$this->path .= '_';
		}

		$this->path .= $matches[2] . '.phtml';

		// Si le chemin pointe vers un fichier inexistant OU illisible (pour cause de droits d'accès)
		// On provoque une erreur
		if( ! is_readable( $this->path ) ) {
			throw new ViewInvalidNameException();
		}
	}

	public function render( array $view_data ): string
	{
		ob_start();

		extract( $view_data );

		// Si c'est une vue partielle, on inclus le fichier de header
		if( $this->is_partial ) {
			require_once self::PARTIAL_PATH. '_header.phtml';
		}

		// Inclusion de la vue demandée
		require_once $this->path;

		// Si c'est une vue partielle, on inclus le fichier de footer
		if( $this->is_partial ) {
			require_once self::PARTIAL_PATH. '_footer.phtml';
		}

		return ob_get_clean();
	}
}