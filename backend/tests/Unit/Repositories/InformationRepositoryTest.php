<?php

namespace Tests\Unit\Repositories;

use App\Repositories\InformationRepository;
use Tests\TestCase;

class InformationRepositoryTest extends TestCase
{
    public function test_add_image_urls_sets_storage_url_or_null(): void
    {
        $repository = new class extends InformationRepository {
            public function addImageUrlsForTest($informationList)
            {
                return $this->addImageUrls($informationList);
            }
        };

        $informationList = collect([
            (object) ['image_path' => '/images/info/banner.png'],
            (object) ['image_path' => null],
        ]);

        $result = $repository->addImageUrlsForTest($informationList);

        $this->assertSame('/storage/images/info/banner.png', $result[0]->image_url);
        $this->assertNull($result[1]->image_url);
    }
}
