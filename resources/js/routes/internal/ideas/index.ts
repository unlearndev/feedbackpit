import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Internal\IdeaDashboardController::__invoke
* @see app/Http/Controllers/Internal/IdeaDashboardController.php:12
* @route '/internal'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/internal',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Internal\IdeaDashboardController::__invoke
* @see app/Http/Controllers/Internal/IdeaDashboardController.php:12
* @route '/internal'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\IdeaDashboardController::__invoke
* @see app/Http/Controllers/Internal/IdeaDashboardController.php:12
* @route '/internal'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Internal\IdeaDashboardController::__invoke
* @see app/Http/Controllers/Internal/IdeaDashboardController.php:12
* @route '/internal'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

const ideas = {
    index: Object.assign(index, index),
}

export default ideas