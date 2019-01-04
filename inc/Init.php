<?php 

/**
 *
 *
 *		@Package Miami Trips
 *
 *
 */

namespace MiamiTrips;

class Init{

	/**
	*	Store all the classes inside an array
	*	@return array of full list of classes.
	*	
	*/
	public static function get_services(){
		return array(
			Base\Enqueue::class,
			Api\Ajax::class,
			Base\Database::class,
			Pages\Cities::class,
			Pages\Hotels::class,
			Pages\Clients::class,
			Pages\Trips::class,
			Pages\Reservations::class,

			Functions\TemplateController::class,
		);
	}


	/**
	*
	*	Loop through all services and register them
	*
	*	@return 
	*
	*/
	public static function register_services(){
		foreach(self::get_services() as $class){
			$service = self::instantiate($class);
			if(method_exists($service, 'register')){
				$service->register();
			}
		}
	}


// 	/**
// 	*
// 	*	Register Service
// 	*	@return Class The Service
// 	*/

	private static function instantiate($class){
		return new $class();
	}



}