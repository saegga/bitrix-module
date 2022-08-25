<?
namespace Sm\Dev\User;

interface OAuth{

	const JWT_TOKEN_NAME = 'Token';
	const JWT_SECRET = '11F63EB24896BCBE3B51DB25A5BA4';
	const JWT_ALGO = 'HS256';
	const COOKIE_REFRESH_TOKEN = 'refresh_token';
	const REFRESH_TOKEN_LIFETIME = 2678400; //60 * 60 * 24 * 30

	function login(string $login, string $password, string $ip);
	function loginOut(string $fingerPrint, string $ip);
	function checkToken(string $token);
	function getUserByRefreshToken(string $fingerprint);
	function getRefreshToken() :string;
	function getToken() :string;
	function authorize(string $token);
	function createToken(int $userId) :string;
	function authorizeById(int $userId, string $fingerprint, $ip) :bool;
}