<?php

namespace app\controllers;

use app\models\UserModel;
use flight\Engine;
use PDO;
use PDOException;

class ApiExampleController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	private function getDBConnection()
	{
		$host = 'localhost';
		$dbname = 'Revision';
		$username = 'root';
		$password = '';
		$charset = 'utf8mb4';

		try {
			$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
			$pdo = new PDO($dsn, $username, $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $pdo;
		} catch (PDOException $e) {
			error_log("Database connection failed: " . $e->getMessage());
			throw $e;
		}
	}

	public function getUsers()
	{
		try {
			$db = $this->getDBConnection();
			$userModel = new UserModel($db);
			$users = $userModel->getAllExcept(0); 

			$this->app->json($users, 200, true, 'utf-8', JSON_PRETTY_PRINT);
		} catch (PDOException $e) {
			$this->app->json([
				'error' => 'Database error',
				'message' => $e->getMessage()
			], 500);
		}
	}

	public function getUser($id)
	{
		try {
			$db = $this->getDBConnection();
			$userModel = new UserModel($db);
			$user = $userModel->getById($id);

			if ($user) {
				$this->app->json($user, 200, true, 'utf-8', JSON_PRETTY_PRINT);
			} else {
				$this->app->json([
					'error' => 'User not found',
					'id' => $id
				], 404);
			}
		} catch (PDOException $e) {
			$this->app->json([
				'error' => 'Database error',
				'message' => $e->getMessage()
			], 500);
		}
	}
}
