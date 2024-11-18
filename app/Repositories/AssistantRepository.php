<?php

namespace App\Repositories;

use App\Models\Assistant;
use App\Models\Supervisor;
use App\Repositories\Interfaces\AssistantRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AssistantRepository implements AssistantRepositoryInterface
{
    public function register(array $data): Assistant
    {
        \DB::beginTransaction();
        try {
            $assistant = Assistant::create($data);
            \DB::commit();
            return $assistant;
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    public function updateAssistantInfo($assistant , array $data)
    {
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('assistant_images', 'public');
            $data['image'] = $imagePath;
        }
        $updated = $assistant->update($data);

        return $updated;
    }

}
