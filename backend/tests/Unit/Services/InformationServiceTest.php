<?php

namespace Tests\Unit\Services;

use App\Repositories\InformationRepository;
use App\Services\InformationService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class InformationServiceTest extends TestCase
{
    public function test_get_information_list_groups_repository_results_by_kind(): void
    {
        config([
            'const.information.infoKindSlider' => 1,
            'const.information.infoKindGrid' => 2,
            'const.information.infoKindList' => 3,
        ]);

        $repository = new class extends InformationRepository {
            public array $calledKinds = [];

            public function getInformationList($infoKind): Collection
            {
                $this->calledKinds[] = $infoKind;

                return collect(['kind_' . $infoKind]);
            }
        };

        $service = new InformationService($repository);

        $result = $service->getInformationList();

        $this->assertSame([1, 2, 3], $repository->calledKinds);
        $this->assertSame(['kind_1'], $result['slider_info']->all());
        $this->assertSame(['kind_2'], $result['grid_info']->all());
        $this->assertSame(['kind_3'], $result['list_info']->all());
    }
}
