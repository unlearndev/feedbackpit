import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Modules\Feedback\Http\Controllers\DashboardController::__invoke
* @see app/Modules/Feedback/Http/Controllers/DashboardController.php:12
* @route '/dashboard'
*/
const DashboardController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DashboardController.url(options),
    method: 'get',
})

DashboardController.definition = {
    methods: ["get","head"],
    url: '/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Modules\Feedback\Http\Controllers\DashboardController::__invoke
* @see app/Modules/Feedback/Http/Controllers/DashboardController.php:12
* @route '/dashboard'
*/
DashboardController.url = (options?: RouteQueryOptions) => {
    return DashboardController.definition.url + queryParams(options)
}

/**
* @see \App\Modules\Feedback\Http\Controllers\DashboardController::__invoke
* @see app/Modules/Feedback/Http/Controllers/DashboardController.php:12
* @route '/dashboard'
*/
DashboardController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: DashboardController.url(options),
    method: 'get',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\DashboardController::__invoke
* @see app/Modules/Feedback/Http/Controllers/DashboardController.php:12
* @route '/dashboard'
*/
DashboardController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: DashboardController.url(options),
    method: 'head',
})

export default DashboardController