<?php

namespace App\Repositories\Interfaces;

use App\Models\Assistant;
use App\Models\Supervisor;
use App\Models\User;

interface AssistantRepositoryInterface
{
    public function register(array $data): Assistant;

    public function updateAssistantInfo($assistant, array $data);

}
