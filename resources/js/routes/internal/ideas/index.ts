import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
import comments from './comments'
import notes from './notes'
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

/**
* @see \App\Http\Controllers\Internal\IdeaDetailController::show
* @see app/Http/Controllers/Internal/IdeaDetailController.php:13
* @route '/internal/ideas/{idea}'
*/
export const show = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/internal/ideas/{idea}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Internal\IdeaDetailController::show
* @see app/Http/Controllers/Internal/IdeaDetailController.php:13
* @route '/internal/ideas/{idea}'
*/
show.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { idea: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { idea: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            idea: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        idea: typeof args.idea === 'object'
        ? args.idea.id
        : args.idea,
    }

    return show.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\IdeaDetailController::show
* @see app/Http/Controllers/Internal/IdeaDetailController.php:13
* @route '/internal/ideas/{idea}'
*/
show.get = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Internal\IdeaDetailController::show
* @see app/Http/Controllers/Internal/IdeaDetailController.php:13
* @route '/internal/ideas/{idea}'
*/
show.head = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const ideas = {
    index: Object.assign(index, index),
    show: Object.assign(show, show),
    comments: Object.assign(comments, comments),
    notes: Object.assign(notes, notes),
}

export default ideas