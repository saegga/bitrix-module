<?

use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routesConfig) {
	/**
	 * @OA\Post(
	 *     path="/get/",
	 *     tags={"user"},
	 *     @OA\RequestBody(
	 *          required=true,
	 *          @OA\JsonContent(
	 *              required={"login", "pass"},
	 *              @OA\Property(property="login", type="string", example="login"),
	 *              @OA\Property(property="pass", type="password", example="pass"),
	 *          ),
	 *     ),
	 *     @OA\Response(
	 *          response=200,
	 *          description="Success and error",
	 *          @OA\JsonContent(
	 *              @OA\Property(property="status", type="string", example="success"),
	 *              @OA\Property(property="data", type="object"),
	 *              @OA\Property(property="errors", type="array", type="array",
	 *                  @OA\Items(
	 *                      @OA\Property(property="message", type="string"),
	 *                      @OA\Property(property="code", type="string"),
	 *                      @OA\Property(property="customData", type="object"),
	 *                  ),
	 *              ),
	 *          ),
	 *     ),
	 * )
	 */
	$routesConfig->get('/get/', function () {
		return "get ...";
	});

	$routesConfig->get('/api-doc/', [\BitrixOA\BitrixUiController::class, 'apidocAction']);



};