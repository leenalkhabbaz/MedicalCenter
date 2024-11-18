<?php

namespace App\Services;

use App\Models\Activities;
use App\Models\CureSession;
use App\Models\medicine;
use App\Models\PatientCondition;
use App\Repositories\Interfaces\ReelRepositoryInterface;

class ReelService
{
    private ReelRepositoryInterface $reelRepository;

    public function __construct(ReelRepositoryInterface $reelRepository)
    {
        $this->reelRepository = $reelRepository;
    }

    public function uploadReel(array $data)
    {

        return $this->reelRepository->uploadReel($data);
    }

    public function generateReelFileName(string $type, int $typeId): string
    {
        switch ($type) {
            case 'medicine':
                $medicine = Medicine::find($typeId);
                return $medicine ? 'medicine_' . str_replace(' ', '_', $medicine->name) : 'medicine_unknown';

            // case 'cure_session':
            //     $session = CureSession::find($typeId);
            //     return $session ? 'session_' . str_replace(' ', '_', $session->name_medical_condition) : 'session_unknown';

            // case 'activity':
            //     $activity = Activities::find($typeId);
            //     return $activity ? 'activity_' . str_replace(' ', '_', $activity->title) : 'activity_unknown';

            default:
                return 'reel';
        }
    }

}
