<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Response;
//use Symfony\Component\HttpFoundation\Response as IlluminateResponse;
use Illuminate\Http\Response as IlluminateResponse;

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
		return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
	}

	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(), $headers); 
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
		return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
	}

}