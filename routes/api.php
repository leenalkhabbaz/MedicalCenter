<?php

use App\Http\Controllers\Assistant\AssistantController as AssistantAssistantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\ReelController;
use App\Http\Controllers\User\PatientConditionController;
use App\Http\Controllers\User\UserAuthController;
use App\Services\NotificationService;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//=========================================User==========================================================//
Route::prefix('user')->group(function () {
    Route::post('register', [UserAuthController::class, 'register'])->name('register');
    Route::post('login', [UserAuthController::class, 'login'])->name('login');
});

// *************************************With Auth***********************************************************//
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
    });

    Route::prefix('patientCondition')->group(function () {
        Route::post('addPatientCondition',  [PatientConditionController::class, 'addPatientCondition']);
        Route::post('updatePatientCondition',  [PatientConditionController::class, 'updatePatientCondition']);
        Route::get('getAllPatientCondition',  [PatientConditionController::class, 'getAllPatientCondition']);
        Route::post('getPatientDetails',  [PatientConditionController::class, 'getPatientDetails']);
    });

    Route::prefix('medicine')->group(function () {
        Route::post('addMedicines',  [MedicineController::class, 'addMedicines']);
        Route::post('updateMedicine',  [MedicineController::class, 'updateMedicine']);
        Route::post('deleteMedicine',  [MedicineController::class, 'deleteMedicine']);
    });

    Route::prefix('home')->group(function () {
        Route::post('getDailyTasks',  [HomeController::class, 'getDailyTasks']);
    });

    Route::prefix('setting')->group(function () {
        Route::post('notificationSettings',  [NotificationSettingController::class, 'notificationSettings']);
    });
});

//=========================================Assistant==========================================================//

Route::post('/assistant/register', [AssistantAssistantController::class, 'register']);

// *************************************With Auth***********************************************************//
Route::middleware(['auth:sanctum', 'auth:assistant'])->group(function () {
    Route::prefix('assistant')->group(function () {
        Route::post('updateAssistantInfo', [AssistantAssistantController::class, 'updateAssistantInfo']);
    });
    Route::prefix('reel')->group(function () {
        Route::post('uploadReel',  [ReelController::class, 'uploadReel']);
    });


});

Route::get('/test-notifications', function (NotificationService $notificationService) {
    $notificationService->sendDailyNotifications();
    return response()->json(['message' => 'Notifications sent']);
});
