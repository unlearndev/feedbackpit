import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Modules\Internal\Http\Controllers\IdeaDashboardController::__invoke
* @see app/Modules/Internal/Http/Controllers/IdeaDashboardController.php:12
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
* @see \App\Modules\Internal\Http\Controllers\IdeaDashboardController::__invoke
* @see app/Modules/Internal/Http/Controllers/IdeaDashboardController.php:12
* @route '/internal'
*/
IdeaDashboardController.url = (options?: RouteQueryOptions) => {
    return IdeaDashboardController.definition.url + queryParams(options)
}

/**
* @see \App\Modules\Internal\Http\Controllers\IdeaDashboardController::__invoke
* @see app/Modules/Internal/Http/Controllers/IdeaDashboardController.php:12
* @route '/internal'
*/
IdeaDashboardController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: IdeaDashboardController.url(options),
    method: 'get',
})

/**
* @see \App\Modules\Internal\Http\Controllers\IdeaDashboardController::__invoke
* @see app/Modules/Internal/Http/Controllers/IdeaDashboardController.php:12
* @route '/internal'
*/
IdeaDashboardController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: IdeaDashboardController.url(options),
    method: 'head',
})

export default IdeaDashboardController