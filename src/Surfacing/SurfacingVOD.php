<?php

declare(strict_types=1);

namespace src\Surfacing;

use src\ParentClasses\SurfacingPrograms;

require_once __DIR__ . '/../ParentClasses/SurfacingPrograms.php';
/**
 * @package Surfacing
 */
class SurfacingVOD extends SurfacingPrograms
{
    public function __construct()
    {
        parent::__construct();
    }

    function setPrograms(array $data): void
    {
        foreach ($data['programs'] as $program)
            if (isset($program['playback_items'])) {
                foreach ($program['playback_items'] as $item)
                    if (str_contains($item['deeplink_payload'], 'replay')) {
                        $minidata=json_decode($item['deeplink_payload'], true);
                        $this->addProgram(new SurfVOD($minidata["mediaId"]));
                        break;
                    }
            }
    }
}