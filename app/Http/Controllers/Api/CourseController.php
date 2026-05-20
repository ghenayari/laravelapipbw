<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // 1. Menampilkan semua kursus beserta nama pengajarnya (GET)
    public function index()
    {
        $courses = Course::with('instructor')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data kursus dan pengajar berhasil diambil',
            'data' => $courses
        ], 200);
    }

    // 2. Menambah data kursus baru (POST)
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan
        $request->validate([
            'instructor_id' => 'required|exists:instructors,id', // ID pengajar harus ada di tabel instructors
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        // Simpan ke database
        $course = Course::create([
            'instructor_id' => $request->instructor_id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data kursus berhasil ditambahkan',
            'data' => $course
        ], 201);
    }
}
