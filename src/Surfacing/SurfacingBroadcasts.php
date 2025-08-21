<?php

declare(strict_types=1);

namespace src\Surfacing;

use src\ParentClasses\SurfacingPrograms;

require_once __DIR__ . '/../ParentClasses/SurfacingPrograms.php';

/**
 * @package Surfacing
 */
class SurfacingBroadcasts extends SurfacingPrograms
{
    public function __construct()
    {
        parent::__construct();
    }

    public function setPrograms(array $data): void
    {
        foreach ($data['programs'] as $program) {
            if (isset($program['program_id'], $program['titles'][0]['title'], $program['playback_items'], $program['descriptions'][0]['description'])) {
                foreach ($program['playback_items'] as $item) {
                    if (isset($item['available_starting'], $item['available_ending'], $item['deeplink_payload'])) {
                        $deeplinkPayload=$item['deeplink_payload'];
                        $deeplinkPayload=json_decode($deeplinkPayload, true);
                        if (isset($deeplinkPayload['videoId'], $deeplinkPayload['type']) && $deeplinkPayload['type'] === 'live') {
                            $this->addProgram(new SurfBroadcast($program['titles'][0]['title'], $item['available_starting'], $item['available_ending'], $deeplinkPayload['videoId'], $program['descriptions'][0]['description']));
                        }
                    }
                }
            }
        }
        $this->filterSurfacingPrograms();
    }

    public function filterSurfacingPrograms(): void
    {
        foreach ($this->programs as $key=>$broadcast) {
            if (!$broadcast->isIn28Hours())
                unset($this->programs[$key]);
        }
    }
}