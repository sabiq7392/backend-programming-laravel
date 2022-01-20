<?php

namespace App\Http\Traits;

trait ResponseTrait {
  public function responseSuccess($data, $message, $statusCode = 200)
	{
		// response ketika success
		$response = [
			'message' => $message,
			'data' => $data,
		];

		return response()->json($response, $statusCode);
	}

  public function responseFail($message = 'Resource not found', $statusCode = 404) 
	{
		// response ketika gagal
		$response = [
			'message' => $message,
		];

		return response()->json($response, $statusCode);
	}
}