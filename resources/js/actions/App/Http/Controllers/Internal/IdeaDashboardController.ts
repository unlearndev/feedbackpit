import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Internal\IdeaDashboardController::__invoke
* @see app/Http/Controllers/Internal/IdeaDashboardController.php:12
* @route '/internal'
*/
const IdeaDashboardController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IdeaDashboardController.url(options),
    method: 'get',
})

IdeaDashboardController.definition = {
    methods: ["get","head"],
    url: '/internal',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Internal\IdeaDashboardController::__invoke
* @see app/Http/Controllers/Internal/IdeaDashboardController.php:12
* @route '/internal'
*/
IdeaDashboardController.url = (options?: RouteQueryOptions) => {
    return IdeaDashboardController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\IdeaDashboardController::__invoke
* @see app/Http/Controllers/Internal/IdeaDashboardController.php:12
* @route '/internal'
*/
IdeaDashboardController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IdeaDashboardController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Internal\IdeaDashboardController::__invoke
* @see app/Http/Controllers/Internal/IdeaDashboardController.php:12
* @route '/internal'
*/
IdeaDashboardController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: IdeaDashboardController.url(options),
    method: 'head',
})

export default IdeaDashboardController