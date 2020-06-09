<?php

namespace Amitav\SortAndFilter\Tests;

use Amitav\SortAndFilter\Tests\TestSupport\TestModel;
use Amitav\SortAndFilter\Tests\TestSupport\TestModelWithProp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class SortTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_sorted_result()
    {
        factory(TestModel::class, 2)->create();

        $request = new Request();
        $request->replace(['foo' => 'bar']);

        $data = TestModel::query()
            ->sort($request)
            ->get();

        $this->assertEquals(2, $data->count());
    }

    /** @test */
    public function it_sorts_data_when_sortable_property_is_not_defined()
    {
        factory(TestModel::class)->create(['age' => 20, 'name' => 'Jhon']);
        factory(TestModel::class)->create(['age' => 40, 'name' => 'Doe']);

        $request = new Request();
        $request->replace([
            'sortBy' => 'age',
            'sortOrder' => 'desc',
        ]);

        $data = TestModel::query()
            ->sort($request)
            ->get()
            ->toArray();

        $this->assertEquals("Jhon", $data[1]['name']);
    }

    /** @test */
    public function it_sorts_by_age_asc_when_order_not_given()
    {
        factory(TestModel::class)->create(['age' => 40, 'name' => 'Jhon']);
        factory(TestModel::class)->create(['age' => 20, 'name' => 'Doe']);
        factory(TestModel::class)->create(['age' => 18, 'name' => 'Assert']);

        $request = new Request();
        $request->replace([
            'sortBy' => 'age',
        ]);

        $data = TestModel::query()
            ->sort($request)
            ->get()
            ->toArray();

        $this->assertEquals("Assert", $data[0]['name']);
    }

    /** @test */
    public function it_allows_sort_with_allowed_field()
    {
        factory(TestModelWithProp::class)->create(['age' => 100]);
        $second = factory(TestModelWithProp::class)->create(['age' => 99]);

        $request = new Request();
        $request->replace([
            'sortBy' => 'age',
        ]);

        $data = TestModelWithProp::query()
            ->sort($request)
            ->get()
            ->toArray();

        $this->assertEquals($second->name, $data[0]['name']);
    }

    /** @test */
    public function it_does_not_allow_unwanted_fields()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        factory(TestModelWithProp::class)->create();
        factory(TestModelWithProp::class)->create();

        $request = new Request();
        $request->replace([
            'sortBy' => 'wins',
        ]);

        TestModelWithProp::query()
            ->sort($request)
            ->get()
            ->toArray();
    }
}
