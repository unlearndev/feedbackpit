import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\AboutController::__invoke
* @see app/Http/Controllers/AboutController.php:9
* @route '/about'
*/
const AboutController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AboutController.url(options),
    method: 'get',
})

AboutController.definition = {
    methods: ["get","head"],
    url: '/about',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AboutController::__invoke
* @see app/Http/Controllers/AboutController.php:9
* @route '/about'
*/
AboutController.url = (options?: RouteQueryOptions) => {
    return AboutController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AboutController::__invoke
* @see app/Http/Controllers/AboutController.php:9
* @route '/about'
*/
AboutController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AboutController.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AboutController::__invoke
* @see app/Http/Controllers/AboutController.php:9
* @route '/about'
*/
AboutController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: AboutController.url(options),
    method: 'head',
})

export default AboutController