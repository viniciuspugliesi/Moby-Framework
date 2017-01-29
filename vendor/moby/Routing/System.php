<?php

namespace Routing;

// Default PHPdependencies
	use \ReflectionParameter;
	use \ReflectionException;

use App\Http\Middleware\Auth;
use Exception\RenderException;
use Routing\Interfaces\InterfaceSystem;

/**
 * Class responsible for instantiates the controller that the route to pass
 *
 */
class System extends Auth implements InterfaceSystem
{
    /**
     * Function responsible for instantiate the controller
     *
     * @var array $url ([0] => 'Controller', [1] => 'method')
     * @var array $params (parameters for pass to $_GET)
     * @return void 
     */
	public static function run($url = [], $params = [])
	{
		$controller	= $url[0];
		$action		= $url[1];
		
		$controller = 'App\Http\\Controllers\\'.$controller.'Controller';
		
		try {
			if (!class_exists($controller)) {
				throw new RenderException('Class ['.$controller.'] does not exist', 30);
			}
			
			$controller = new $controller();
			
			if (!method_exists($controller, $action)) {
				throw new RenderException('Method ['.$action.'] does not exist in the class ['.$controller.']', 20);
			}
			
			$reflectionRequest = new ReflectionParameter(['App\Http\\Controllers\\'.$url[0].'Controller', $action], 0);
			$class_request = $reflectionRequest->getClass();
			
			$class_request = $class_request->name;
			
			if (!class_exists($class_request)) {
				throw new RenderException('Request class ['.$class_request.'] does not exist', 1010);
			}
						
			array_unshift($params, new $class_request());
			
			return call_user_func_array([$controller, $action], $params);
		} catch (ReflectionException $e) {
			return call_user_func_array([$controller, $action], $params);
		} catch (RenderException $e) {
			$e->render($e->showErrors(), $e);
		}
	}
}