<?php

namespace Tests\Feature\Repositories;

use App\Repositories\InformationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InformationRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_information_list_returns_visible_items_by_kind_ordered_by_sort_order(): void
    {
        $targetKind = 901;
        $otherKind = 902;

        DB::table('info')->insert([
            [
                'name' => 'Second visible information',
                'image_path' => '/images/info/second.png',
                'kind' => $targetKind,
                'link_url' => null,
                'visible_flag' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'First visible information',
                'image_path' => null,
                'kind' => $targetKind,
                'link_url' => null,
                'visible_flag' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hidden information',
                'image_path' => null,
                'kind' => $targetKind,
                'link_url' => null,
                'visible_flag' => false,
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Other kind information',
                'image_path' => null,
                'kind' => $otherKind,
                'link_url' => null,
                'visible_flag' => true,
                'sort_order' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $result = (new InformationRepository())->getInformationList($targetKind);

        $this->assertSame(
            ['First visible information', 'Second visible information'],
            $result->pluck('name')->all()
        );
        $this->assertNull($result[0]->image_url);
        $this->assertSame('/storage/images/info/second.png', $result[1]->image_url);
    }
}
