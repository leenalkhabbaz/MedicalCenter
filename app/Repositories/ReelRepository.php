<?php

namespace App\Repositories;

use App\Models\Activities;
use App\Models\CureSession;
use App\Models\medicine;
use App\Models\PatientCondition;
use App\Models\Reel;
use App\Repositories\Interfaces\ReelRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class ReelRepository implements ReelRepositoryInterface
{

    public function uploadReel(array $data)
    {
        $reelName = $this->getNameByTypeAndId($data['type'], $data['type_id']);

        if (!$reelName) {
            throw new \Exception("Item not found for type: {$data['type']} with ID: {$data['type_id']}");
        }

        if (isset($data['reel'])) {
            $extension = $data['reel']->getClientOriginalExtension();
            $fileName = $reelName . '.' . $extension;
            $imagePath = $data['reel']->storeAs('reels', $fileName, 'public');
            $data['reel'] = $imagePath;
        }

        if (isset($data['thumbnail'])) {
            $extension = $data['thumbnail']->getClientOriginalExtension();
            $fileName = $reelName . '.' . $extension;
            $imagePath = $data['thumbnail']->storeAs('reels', $fileName, 'public');
            $data['thumbnail'] = $imagePath;
        }

        return Reel::create($data);
    }

    private function getNameByTypeAndId(string $type, int $typeId): ?string
    {
        switch ($type) {
            case 'medicine':
                $item = medicine::find($typeId);
                return $item ? $item->name : null;

            // case 'session':
            //     $item = CureSession::find($typeId);
            //     return $item ? $item->name : null;

            // case 'activity':
            //     $item = Activities::find($typeId);
            //     return $item ? $item->name : null;

            default:
                return null;
        }
    }
}
