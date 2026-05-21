<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DoctorApiController;

// ── Public endpoints ──────────────────────────────────────────────────────────

// Doctor login
Route::post('/login', [DoctorApiController::class, 'login']);

// Patient polling: check appointment status (no auth — patient has the ID from session)
Route::get('/appointment-status/{id}', [DoctorApiController::class, 'checkStatus']);

// Available slots for a doctor+date (used by the booking calendar JS)
Route::get('/available-slots', [DoctorApiController::class, 'availableSlots']);

// ── Sanctum-protected (doctor must be logged in via token) ────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/appointments',          [DoctorApiController::class, 'getAppointments']);
    Route::post('/appointment-status',   [DoctorApiController::class, 'updateStatus']);
    Route::get('/doctor-profile',        [DoctorApiController::class, 'getProfile']);
    Route::post('/update-profile',       [DoctorApiController::class, 'updateProfile']);
    Route::get('/today-appointments',  [DoctorApiController::class, 'getTodayAppointments']);
});
