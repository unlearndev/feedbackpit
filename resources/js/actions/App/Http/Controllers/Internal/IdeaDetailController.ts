import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
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

const IdeaDetailController = { show }

export default IdeaDetailController