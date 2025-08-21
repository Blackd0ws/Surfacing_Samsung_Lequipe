<?php

declare(strict_types=1);

namespace src\Surfacing;

use src\ParentClasses\SurfacingPrograms;

require_once __DIR__ . '/../ParentClasses/SurfacingPrograms.php';
/**
 * @package Surfacing
 */
class SurfacingExplores extends SurfacingPrograms
{
    public function __construct()
    {
        parent::__construct();
    }

    function setPrograms(array $data): void
    {
        foreach ($data['programs'] as $program) {
            if (isset($program['playback_items'], $program['descriptions'], $program['titles'])) {
                foreach ($program['playback_items'] as $item) {
                    if (str_contains($item['deeplink_payload'], 'premium')) {
                        $minidata=$item['deeplink_payload'];
                        $minidata=json_decode($minidata, true);
                        $chemin=$minidata["path"];
                        if (preg_match('/\/(\d+)$/', $chemin, $matches)) {
                            $id=(int)$matches[1];
                            $start_date=$item['available_starting'];
                            $end_date=$item['available_ending'];
                            $description=$program['descriptions'][0]['description'];
                            $title=$program['titles'][0]['title'];
                            $this->addProgram(new SurfExplore($id, $title, $start_date, $end_date, $description));
                        }
                    }
                }
            }
        }
    }
}