import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\ReactionController::__invoke
* @see app/Http/Controllers/ReactionController.php:11
* @route '/feedback/{idea}/reactions'
*/
const ReactionController = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ReactionController.url(args, options),
    method: 'post',
})

ReactionController.definition = {
    methods: ["post"],
    url: '/feedback/{idea}/reactions',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ReactionController::__invoke
* @see app/Http/Controllers/ReactionController.php:11
* @route '/feedback/{idea}/reactions'
*/
ReactionController.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return ReactionController.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ReactionController::__invoke
* @see app/Http/Controllers/ReactionController.php:11
* @route '/feedback/{idea}/reactions'
*/
ReactionController.post = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ReactionController.url(args, options),
    method: 'post',
})

export default ReactionController