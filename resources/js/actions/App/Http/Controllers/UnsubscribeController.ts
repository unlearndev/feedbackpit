import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\UnsubscribeController::__invoke
* @see app/Http/Controllers/UnsubscribeController.php:12
* @route '/feedback/{idea}/unsubscribe/{user}'
*/
const UnsubscribeController = (args: { idea: number | { id: number }, user: number | { id: number } } | [idea: number | { id: number }, user: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: UnsubscribeController.url(args, options),
    method: 'get',
})

UnsubscribeController.definition = {
    methods: ["get","head"],
    url: '/feedback/{idea}/unsubscribe/{user}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\UnsubscribeController::__invoke
* @see app/Http/Controllers/UnsubscribeController.php:12
* @route '/feedback/{idea}/unsubscribe/{user}'
*/
UnsubscribeController.url = (args: { idea: number | { id: number }, user: number | { id: number } } | [idea: number | { id: number }, user: number | { id: number } ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
            idea: args[0],
            user: args[1],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        idea: typeof args.idea === 'object'
        ? args.idea.id
        : args.idea,
        user: typeof args.user === 'object'
        ? args.user.id
        : args.user,
    }

    return UnsubscribeController.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\UnsubscribeController::__invoke
* @see app/Http/Controllers/UnsubscribeController.php:12
* @route '/feedback/{idea}/unsubscribe/{user}'
*/
UnsubscribeController.get = (args: { idea: number | { id: number }, user: number | { id: number } } | [idea: number | { id: number }, user: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: UnsubscribeController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\UnsubscribeController::__invoke
* @see app/Http/Controllers/UnsubscribeController.php:12
* @route '/feedback/{idea}/unsubscribe/{user}'
*/
UnsubscribeController.head = (args: { idea: number | { id: number }, user: number | { id: number } } | [idea: number | { id: number }, user: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: UnsubscribeController.url(args, options),
    method: 'head',
})

export default UnsubscribeController