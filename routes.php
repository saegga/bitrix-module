<?

use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routesConfig) {
	$routesConfig->get('/get/', function () {
		return "get ...";
	});

	$routesConfig->get('/api-doc/', [\BitrixOA\BitrixUiController::class, 'apidocAction']);



};