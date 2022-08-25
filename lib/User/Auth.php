<?

namespace SM\Dev\User;

class Auth implements OAuth {

	function login(string $login, string $password, string $ip)
	{
		// TODO: Implement login() method.
	}

	function loginOut(string $fingerPrint, string $ip)
	{
		// TODO: Implement loginOut() method.
	}

	function checkToken(string $token)
	{
		// TODO: Implement checkToken() method.
	}

	function getUserByRefreshToken(string $fingerprint)
	{
		// TODO: Implement getUserByRefreshToken() method.
	}

	function getRefreshToken(): string
	{
		// TODO: Implement getRefreshToken() method.
	}

	function getToken(): string
	{
		// TODO: Implement getToken() method.
	}

	function authorize(string $token)
	{
		// TODO: Implement authorize() method.
	}

	function createToken(int $userId): string
	{
		// TODO: Implement createToken() method.
	}

	function authorizeById(int $userId, string $fingerprint, $ip): bool
	{
		// TODO: Implement authorizeById() method.
	}
}