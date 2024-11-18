<?php

namespace App\Services;

use App\Models\Assistant;
use App\Models\Supervisor;
use App\Repositories\Interfaces\AssistantRepositoryInterface;

class AssistantService
{
    private AssistantRepositoryInterface $assistantRepository;

    public function __construct(AssistantRepositoryInterface $assistantRepository)
    {
        $this->assistantRepository = $assistantRepository;
    }

    public function register(array $data): Assistant
    {
        if (!isset($data['language'])) {
            $data['language'] = 'ar';
        }
        return $this->assistantRepository->register($data);
    }

    public function updateAssistantInfo($assistant , array $data)
    {
        return $this->assistantRepository->updateAssistantInfo($assistant, $data);
    }


}
