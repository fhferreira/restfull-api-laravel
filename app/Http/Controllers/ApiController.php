<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class ApiController extends Controller {

	protected $statusCode = 200;

	public function getStatusCode()
	{
		return $this->statusCode;
	}

	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

	public function respondNotFound($message = 'Not Found')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respond($data, $headers = [])
	{
		return \Response::json($data, $this->getStatusCode(), $headers); 
	}

	public function respondWithError($message)
	{
		return $this->respond([
					'error' => [
							'message' => $message,
							'code' => $this->getStatusCode()
						]
				]);
	}

	public function respondInternalError($message = 'Internal Error!') 
	{
		return $this->setStatusCode(500)->respondWithError($message);
	}

}