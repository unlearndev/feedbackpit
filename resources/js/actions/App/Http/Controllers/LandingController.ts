import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\LandingController::__invoke
* @see app/Http/Controllers/LandingController.php:9
* @route '/'
*/
const LandingController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LandingController.url(options),
    method: 'get',
})

LandingController.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\LandingController::__invoke
* @see app/Http/Controllers/LandingController.php:9
* @route '/'
*/
LandingController.url = (options?: RouteQueryOptions) => {
    return LandingController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\LandingController::__invoke
* @see app/Http/Controllers/LandingController.php:9
* @route '/'
*/
LandingController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: LandingController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\LandingController::__invoke
* @see app/Http/Controllers/LandingController.php:9
* @route '/'
*/
LandingController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: LandingController.url(options),
    method: 'head',
})

export default LandingController