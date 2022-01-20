<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
	public function index()
	{
		$students = Student::all();
		// $no_students = count($students) > 0;

		if (!empty($students)) {
			$response = [
				'message' => 'Get all students',
				'data' => $students,
			];

			return response()->json($response, 200);
		} else {
			$response = [
				'message' => 'Data not found'
			];

			return response()->json($response, 200);
		}
	}

	public function store(Request $request) 
	{

		// $input = [
		// 	'nama' => $request->nama,
		// 	'nim' => $request->nim,
		// 	'email' => $request->email,
		// 	'jurusan' => $request->jurusan
		// ];

		$student = Student::create($request->all());

		$response = [
			'message' => 'Student is created succesfully',
			'data' => $student,
		];

		return response()->json($response, 201);
	}

	public function show($id) 
	{
		$student = Student::find($id);

		if ($student) {
			$response = [
				'message' => 'Get detail student',
				'data' => $student
			];
	
			return response()->json($response, 200);
		} else {
			$response = [
				'message' => 'Data not found'
			];
			
			return response()->json($response, 404);
		}
	}

	public function update(Request $request, $id)
	{
		$student = Student::find($id);

		if ($student) {
			$response = [
				'message' => 'Student is updated',
				'data' => $student->update($request->all())
			];
	
			return response()->json($response, 200);
		} else {
			$response = [
				'message' => 'Data not found'
			];

			return response()->json($response, 404);
		}
	}

	public function destroy($id)
	{
		$student = Student::find($id);

		if ($student) {
			$response = [
				'message' => 'Student is delete',
				'data' => $student->delete()
			];

			return response()->json($response, 200); 
		} else {
			$response = [
				'message' => 'Data not found'
			];

			return response()->json($response, 404);
		}
	}
}
