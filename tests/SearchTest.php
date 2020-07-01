<?php

namespace Amitav\SortAndFilter\Tests;

use Amitav\SortAndFilter\Tests\TestSupport\TestModel;
use Amitav\SortAndFilter\Tests\TestSupport\TestModelWithProp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_result()
    {
        factory(TestModel::class, 2)->create();

        $request = new Request();
        $request->replace(['foo' => 'bar']);

        $data = TestModel::query()
            ->search($request)
            ->get();

        $this->assertEquals(2, $data->count());
    }

    /** @test */
    public function it_returns_like_query_result()
    {
        factory(TestModel::class)->create(['country' => 'India']);
        factory(TestModel::class)->create(['country' => 'Indonesia']);

        $request = new Request();
        $request->replace([
            'searchBy' => 'country',
            'searchValue' => 'Ind',
        ]);

        $data = TestModel::query()
            ->search($request)
            ->get();

        $this->assertEquals(2, $data->count());
    }

    /** @test */
    public function it_searches_any_data_when_searchable_property_is_not_defined()
    {
        factory(TestModel::class)->create(['name' => 'Amit']);
        factory(TestModel::class)->create(['name' => 'Amitav']);

        $request = new Request();
        $request->replace([
            'searchBy' => 'name',
            'searchValue' => 'Amit',
        ]);

        $data = TestModel::query()
            ->search($request)
            ->get();

        $this->assertEquals(2, $data->count());
    }

    /** @test */
    public function it_requires_both_field_and_value()
    {
        factory(TestModel::class)->create(['country' => 'India']);
        factory(TestModel::class)->create(['country' => 'Canada']);

        $request = new Request();
        $request->replace([
            'searchBy' => 'name',
        ]);

        $data = TestModel::query()
            ->search($request)
            ->get();

        $this->assertEquals(2, $data->count());
    }

    /** @test */
    public function it_searches_by_country_when_field_and_value_given()
    {
        factory(TestModelWithProp::class)->create(['country' => 'India']);
        factory(TestModelWithProp::class)->create(['country' => 'Canada']);
        factory(TestModelWithProp::class)->create(['country' => 'France']);
        factory(TestModelWithProp::class)->create(['country' => 'Indonesia']);

        $request = new Request();
        $request->replace([
            'searchBy' => 'country',
            'searchValue' => 'Ind',
        ]);

        $data = TestModelWithProp::query()
            ->search($request)
            ->get();

        $this->assertEquals(2, $data->count());
    }

    /** @test */
    public function it_does_not_allow_unwanted_fields()
    {
        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        factory(TestModelWithProp::class)->create(['name' => 'India']);
        factory(TestModelWithProp::class)->create(['name' => 'Canada']);
        factory(TestModelWithProp::class)->create(['name' => 'France']);
        factory(TestModelWithProp::class)->create(['name' => 'Indonesia']);

        $request = new Request();
        $request->replace([
            'searchBy' => 'name',
            'searchValue' => 'Ind',
        ]);

        $data = TestModelWithProp::query()
            ->search($request)
            ->get();

        $this->assertEquals(2, $data->count());
    }
}
