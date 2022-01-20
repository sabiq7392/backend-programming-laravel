<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnimalController extends Controller
{
	public $animals = [
		[
			"name" => "kucing",
		],
		[
			"name" => "ayam",
		],
		[
			"name" => "ikan"
		]
	];
	// public $animals = [];

	public function index() 
	{
		foreach ($this->animals as $animal) {
			echo "nama hewan: $animal[name]  <br>";
		}
	}

	public function store(Request $request) 
	{
		array_push($this->animals, $request);
		$this->index();
	}

	public function update(Request $request, $id) 
	{
		echo 'Update animals '.$this->animals[$id]['name'].' to '.$request->name.'<br>';
		// echo "Update animals $this->animals[$id][name] to $request->name <br>";
		$this->animals[$id] = $request;
		$this->index();
		
		// $anAnimal = $this->find($id);
		// $this->animals[$anAnimal] = $request;
		// $this->index();
	}

	public function destroy($id) 
	{
		echo "Menghapus data animals id: $id <br>";
		array_splice($this->animals, $id, 1);
		$this->index();
	}

	// private function find($animal) {
	// 	array_search($animal, $this->animals);
	// }
}
