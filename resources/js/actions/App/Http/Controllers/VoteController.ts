import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\VoteController::__invoke
* @see app/Http/Controllers/VoteController.php:11
* @route '/feedback/{idea}/vote'
*/
const VoteController = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: VoteController.url(args, options),
    method: 'post',
})

VoteController.definition = {
    methods: ["post"],
    url: '/feedback/{idea}/vote',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\VoteController::__invoke
* @see app/Http/Controllers/VoteController.php:11
* @route '/feedback/{idea}/vote'
*/
VoteController.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return VoteController.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\VoteController::__invoke
* @see app/Http/Controllers/VoteController.php:11
* @route '/feedback/{idea}/vote'
*/
VoteController.post = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: VoteController.url(args, options),
    method: 'post',
})

export default VoteController