<?php

namespace App\Http\Controllers;

use App\Models\Statuses;

class StatusesController extends Controller
{
	public function autoFill()
	{
		$status = Statuses::upsert([
			[
				'name' => 'Positive',
			],
			[
				'name' => 'Recovered',
			],
			[
				'name' => 'Dead',
			],
		], ['name']);

		$response = [
			'message' => 'Status created',
			'data' => $status,
		];

		return response()->json($response, 201);
	}
}
