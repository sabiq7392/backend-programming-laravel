<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patients extends Model
{
	use HasFactory;

	// kolom table yang dapat bisa diisi
	protected $fillable = [
		'name', 
		'phone', 
		'address', 
		'statuses_id',
		'in_date_at',
		'out_date_at',
	];

	public function allData()
	{
		// mendapatkan semua data
		return $this->joinData()->get();
	}

	public function findById($id)
	{
		// mencari data berdasarkan id
		return $this->joinData()
								->where('patients.id', $id)
								->first();
	}

	public function findByStatus($id) 
	{
		// mencari data berdasarkan status
		return $this->joinData()
								->where('statuses_id', $id)
								->get();
	}

	public function findByName($name)
	{
		// mencari data berdasarkan name
		return $this->joinData()
								->where('patients.name', $name)
								->get();
	}

	private function joinData()
	{
		// menggabungkan table patients dan status
		return DB::table('patients')
							->select('patients.id', 'patients.name', 'phone', 'address', 'statuses.name as statuses', 'in_date_at', 'out_date_at') 
							->join('statuses', 'statuses.id', '=', 'patients.statuses_id');
	}
}
