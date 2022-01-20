<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ResponseTrait;

class PatientsController extends Controller
{
	use ResponseTrait;
	
	public function __construct()
	{
		// memanggil model patients
		$this->patientsModel = new Patients();
	}

	public function index()
	{
		// METHOD untuk menampilkan seluruh data pasien

		// mendapatkan semua data
		$patients = $this->patientsModel->allData();

		// check apakah terdapat pasien di array
		$patientsNotExist = count($patients) == 0;

		// kondisi ketika pasien tidak ada, maka memunculkan response gagal menampilkan karena data pasien kosong
		if ($patientsNotExist) {
			return $this->responseFail('Data is empty', 200);
		}

		// kondisi ketika pasien ada, maka memunculkan response sukses menampilkan semua data pasien
		return $this->responseSuccess($patients, 'Get all resource');
	}

	public function store(Request $request)
	{
		// METHOD untuk menambahkan data pasien

		// kondisi ketika kolom status_id kurang dari atau sama dengan 3 (status exist)
		if ($request->statuses_id <= 3) {
			$positive = 1;
			// validasi rules
			$rules = [
				'name' => 'required',
				'phone' => 'required|numeric',
				'address' => 'required',
				'statuses_id' => 'required|numeric',
				'in_date_at' => 'required',
				'out_date_at' => 'required',
			];

			// kondisi ketika status pasien bukan positif maka akan mengambil semua input
			if ($request->statuses_id != $positive) {
				return $this->storePatientByRules($request->all(), $rules);
			}

			// kondisi ketika pasien positif 

			$outDateAt = 5;
			$justRemoveThis = 1;

			// hapus out_date_at pada array rules
			array_splice($rules, $outDateAt, $justRemoveThis); 

			// input yang akan dihasilan ketika pasien positif
			// dan memaksa out_date_at bernilai null
			$createData = [
				'name' => $request->name,
				'phone' => $request->phone,
				'address' => $request->address,
				'statuses_id' => $request->statuses_id,
				'in_date_at' => $request->in_date_at,
				'out_date_at' => null,
			];

			return $this->storePatientByRules($createData, $rules);
		}

		// kondisi ketika status_id lebih dari 3 (status didnt exist)
		// maka akan memunculkan response gagal menambahkan data
		return $this->responseFail(
			'cannot insert more than 4 value in status_id. Try, 1 = Positive, 2 = Recovered, 3 = Dead.',
			412
		);
	}

	public function show($id)
	{
		// METHOD untuk menampilkan detail data pasien
		
		// mencari pasien berdasarkan id
		$patient = $this->patientsModel->findById($id);
		// $patient = Patients::find($id);
		// check apakah pasien tidak ada
		$patientsNotExist = $patient == null;

		// kondisi ketika pasien tidak ada, maka akan memunculkan response gagal  memunculkan detail data pasien
		if ($patientsNotExist) {
			return $this->responseFail();
		}

		// kondisi ketika pasien ada, maka akan memunculkan response sukses memunculkan detail data pasien
		return $this->responseSuccess($patient, 'Get detail resource');
	}

	public function update(Request $request, $id)
	{
		// METHOD untuk mengupdate/edit data pasien

		// mencari pasien berdasarkan id
		$patient = Patients::find($id);
		// check pasien apakah tidak ada
		$patientsNotExist = $patient == null;

		// kondisi ketika pasien tidak ada, maka memunculkan response gagal meng-update data pasien
		if ($patientsNotExist) {
			return $this->responseFail();
		}

		// kondisi ketika pasien ada, maka memunculkan response sukses meng-update data pasien
		return $this->responseSuccess(
			$patient->update($request->all()),
			'Resource is update successfully'
		);
	}

	public function destroy($id)
	{
		// METHOD untuk menghapus data pasien
		
		// mencari pasien berdasarkan id
		$patient = Patients::find($id);
		// check apakah pasien tidak ada
		$patientNotExist = $patient == null;

		// kondisi ketika pasien tidak ada, maka memunculkan response gagal menghapus data pasien
		if ($patientNotExist) {
			return $this->responseFail();
		}

		// kondisi ketika pasien ada, maka memunculkan response succes menghapus data pasien
		return $this->responseSuccess(
			$patient->delete(), 
			'Resource is delete successfully'
		);
	}   

	public function search($name)
	{
		// METHOD untuk mencari pasien berdasarkan nama

		// cari pasien berdasarkan nama
		$patients = $this->patientsModel->findByName($name);
		// check apakah pasien tidak ada
		$patientsNotExist = count($patients) == 0;

		// kondisi ketika pasien tidak ada, maka memunculkan response gagal 
		// menampilkan pasien yang dicari berdasakan nama 
		if ($patientsNotExist) {
			return $this->responseFail();
		}

		// kondisi ketika pasien ada, maka memunculkan response sukses dan 
		// menampilkan pasien yang dicari berdasarkan nama
		return $this->responseSuccess($patients, 'Searched Resource');
	}

	public function positive() 
	{
		// METHOD untuk mencari pasien dengan status positif

		$positive = 1;
		// mencari pasien berdasarkan status positif
		$patients = $this->patientsModel->findByStatus($positive);
		// $patients = Patients::where('status_id', $positive)->get();
		// check apakah pasien tidak ada
		$patientsNotExist = count($patients) == 0;

		// kondisi ketika pasien tidak ada, maka memunculkan response gagal
		// menampilkan pasien dengan status positif
		if ($patientsNotExist) {
			return $this->responseFail();
		}

		// kondisi ketika pasien ada, maka memunculkan response sukses
		// menampilakna pasien dengan status positif
		return $this->responseSuccess($patients, 'Get positive resource');
	}

	public function recovered()
	{
		// METHOD untuk mencari pasien dengan status recovered

		$recovered = 2;
		// mencari pasien dengan status recovered
		$patients = $this->patientsModel->findByStatus($recovered);
		// $patients = Patients::where('status_id', $recovered)->get();
		// check apak pasien tidak ada
		$patientsNotExist = count($patients) == 0;


		// kondisi ketika pasien tidak ada, maka memunculkan response gagal
		// menampilkan pasien dengan status recovered
		if ($patientsNotExist) {
			return $this->responseFail();
		}

		// kondisi ketika pasien ada, maka memunculkan response sukses
		// menampilkan pasien dengan status recovered
		return $this->responseSuccess($patients, 'Get recovered resource');
	}

	public function dead()
	{
		// METHOD untuk mencari pasien dengan status dead

		$dead = 3;
		// mencari pasien berdasarkan status dead
		$patients = $this->patientsModel->findByStatus($dead);
		// $patients = Patients::where('status_id', $dead)->get();
		// check apakah pasien tidak ada
		$patientsNotExist = count($patients) == 0;

		// kondisi ketika pasien tidak ada, maka memunculkan response gagal
		// menampilkan pasien dengan status dead
		if ($patientsNotExist) {
			return $this->responseFail();
		}

		// kondisi ketika pasien ada, maka memunculkan response sukses
		// menampilkan pasien dengan status dead
		return $this->responseSuccess($patients, 'Get dead resource');
	}

	private function storePatientByRules($data, $rules)
	{
		// METHOD menambahkan pasien berdasarkan rules

		// validasi input apakah sesuai dengan rules
		$validator = Validator::make($data, $rules);

		// kondisi ketika validasi gagal maka memunculkan response gagal
		// menambahkan pasien
		if ($validator->fails()) {
			return response($validator->errors(), 411);
		}

		// kondisi ketika validasi sukses maka memunculkan response sukses
		// dan data sukes ditambahkan
		$patient = Patients::create($data);
		return $this->responseSuccess(
			$patient, 
			'Resource is added successfully', 
			201
		);
	}
}
