<?php

namespace Amitav\SortAndFilter;

use Illuminate\Http\Request;

trait SortAndFilter
{
    public function scopeSort($query, Request $req)
    {
        $query->when($req->has(config("sort-and-filter.sort-by-field")), function ($query) use ($req) {
            if ($this->sortable !== null && count($this->sortable) !== 0) {
                if (! in_array($req->input(config("sort-and-filter.sort-by-field")), $this->sortable)) {
                    $message = config("sort-and-filter.sort-not-allowed");
                    abort(400, $message);
                }
            }

            if ($req->has(config("sort-and-filter.sort-order-field"))) {
                $query->orderBy($req->input(config("sort-and-filter.sort-by-field")), $req->input(config("sort-and-filter.sort-order-field")));
            } else {
                $query->orderBy($req->input(config("sort-and-filter.sort-by-field")), 'asc');
            }
        });
    }

    public function scopeFilter($query, Request $req)
    {
        $query->when(($req->has(config("sort-and-filter.filter-by-field")) && $req->has('config("sort-and-filter.filter-value-field")')), function ($query) use ($req) {
            if ($this->filterable !== null && count($this->filterable) !== 0) {
                if (! in_array($req->input(config("sort-and-filter.filter-by-field")), $this->filterable)) {
                    $message = config("sort-and-filter.filter-not-allowed");
                    abort(400, $message);
                }
            }

            $query->where($req->input(config("sort-and-filter.filter-by-field")), $req->input('config("sort-and-filter.filter-value-field")'));
        });
    }

    public function scopeSearch($query, Request $req)
    {
        $query->when(($req->has(config("sort-and-filter.search-by-field")) && $req->has(config("sort-and-filter.search-value-field"))), function ($query) use ($req) {
            if ($this->searchable !== null && count($this->searchable) !== 0) {
                if (! in_array($req->input(config("sort-and-filter.search-by-field")), $this->searchable)) {
                    $message = config("sort-and-filter.search-not-allowed");
                    abort(400, $message);
                }
            }

            $query->where($req->input(config("sort-and-filter.search-by-field")), 'like', "{$req->input(config("sort-and-filter.search-value-field"))}%");
        });
    }
}
