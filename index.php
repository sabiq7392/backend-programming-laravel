<?php

class Animal {
  public $animals;

  public function __construct($data) {
    $this->animals = $data;
  }

  public function index() {
    foreach ($this->animals as $animal) {
      echo "$animal <br>";
    }
    
    return $this;
  }

  public function store($data) {
    array_push($this->animals, $data);
    $this->index();

    return $this;
  }

  public function update($animal, $data) {
    $anAnimal = $this->find($animal);
    $this->animals[$anAnimal] = $data;

    $this->index();

    return $this;
  }

  public function destroy($animal) {
    $anAnimal = $this->find($animal);

    array_splice($this->animals, $anAnimal, 1);
    $this->index();

    return $this;
  }

  private function find($animal) {
    return array_search($animal, $this->animals);
  }
}

$animal = new Animal(['anjing', 'kucing', 'babi']);

echo 'Index - Menampilkan seluruh hewan <br>';
$animal->index();
echo '<br>';

echo 'Store - Menambahkan hewan baru <br>';
$animal->store('ikan');
echo '<br>';

echo 'Update - Mengupdate hewan <br>';
$animal->update('anjing', 'buaya');
echo '<br>';


echo 'Destroy - Menghapus hewan <br>';
$animal->destroy('buaya');
echo '<br>';

