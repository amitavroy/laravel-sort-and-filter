<?php

return [
    /*
     * Choose the field on which you want to perform operations. 
     * This option is useful for systems that use camelCase or Snake_case middleware for option.
     */
    'sort-by-field'         => 'sortBy',
    'sort-order-field'      => 'sortOrder',
    'filter-by-field'       => 'filterBy',
    'filter-value-field'    => 'filterValue',
    'search-by-field'       => 'searchBy'
    'search-value-field'    => 'searchValue'
    /*
     * This message will be displayed as an error when the field
     * for sorting in request doesn't match with the array
     * defined inside the model.
     */
    "sort-not-allowed" => "This field is not allowed for sorting.",

    /*
     * This message will be displayed as an error when the field
     * for filter in request doesn't match with the array
     * defined inside the model.
     */
    "filter-not-allowed" => "This field is not allowed for filtering.",

    /*
     * This message will be displayed as an error when the field
     * for search in request doesn't match with the array
     * defined inside the model.
     */
    "search-not-allowed" => "This field is not allowed for searching.",
];
