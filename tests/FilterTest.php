<?php

namespace Amitav\SortAndFilter\Tests;

use Amitav\SortAndFilter\Tests\TestSupport\TestModel;
use Amitav\SortAndFilter\Tests\TestSupport\TestModelWithProp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_filtered_result()
    {
        factory(TestModel::class)->create();
        factory(TestModel::class)->create();

        $request = new Request();
        $request->replace(['foo' => 'bar']);

        $data = TestModel::query()
            ->filter($request)
            ->get();

        $this->assertEquals(2, $data->count());
    }

    /** @test */
    public function it_returns_only_the_exact_value_not_matching_value()
    {
        factory(TestModel::class)->create(['country' => 'India']);
        factory(TestModel::class)->create(['country' => 'Indonesia']);

        $request = new Request();
        $request->replace([
            'filterBy' => 'country',
            'filterValue' => 'India',
        ]);

        $data = TestModel::query()
            ->filter($request)
            ->get();

        $this->assertEquals(1, $data->count());
    }

    /** @test */
    public function it_filters_any_data_when_filterable_property_is_not_defined()
    {
        factory(TestModel::class)->create(['age' => 20, 'name' => 'Jhon']);
        factory(TestModel::class)->create(['age' => 40, 'name' => 'Doe']);

        $request = new Request();
        $request->replace([
            'filterBy' => 'age',
            'filterValue' => 20,
        ]);

        $data = TestModel::query()
            ->filter($request)
            ->get()
            ->toArray();

        $this->assertEquals("Jhon", $data[0]['name']);
    }

    /** @test */
    public function it_requires_both_field_and_value()
    {
        factory(TestModel::class)->create(['wins' => 40, 'name' => 'Jhon']);
        factory(TestModel::class)->create(['wins' => 20, 'name' => 'Doe']);
        factory(TestModel::class)->create(['wins' => 20, 'name' => 'Assert']);

        $request = new Request();
        $request->replace([
            'filterBy' => 'wins',
        ]);

        $data = TestModelWithProp::query()
            ->filter($request)
            ->get();

        $this->assertEquals(3, $data->count());
    }

    /** @test */
    public function it_filters_by_wins_when_field_and_value_given()
    {
        factory(TestModel::class)->create(['wins' => 40, 'name' => 'Jhon']);
        factory(TestModel::class)->create(['wins' => 20, 'name' => 'Doe']);
        factory(TestModel::class)->create(['wins' => 18, 'name' => 'Assert']);

        $request = new Request();
        $request->replace([
            'filterBy' => 'wins',
            'filterValue' => 18,
        ]);

        $data = TestModelWithProp::query()
            ->filter($request)
            ->get()
            ->toArray();

        $this->assertEquals("Assert", $data[0]['name']);
    }

    /** @test */
    public function it_does_not_allow_unwanted_fields()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        factory(TestModelWithProp::class)->create();
        factory(TestModelWithProp::class)->create();

        $request = new Request();
        $request->replace([
            'filterBy' => 'age',
            'filterValue' => 20,
        ]);

        TestModelWithProp::query()
            ->filter($request)
            ->get()
            ->toArray();
    }
}
