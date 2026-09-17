import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Modules\Internal\Http\Controllers\IdeaStatusController::update
* @see app/Modules/Internal/Http/Controllers/IdeaStatusController.php:17
* @route '/internal/ideas/{idea}/status'
*/
export const update = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/internal/ideas/{idea}/status',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Modules\Internal\Http\Controllers\IdeaStatusController::update
* @see app/Modules/Internal/Http/Controllers/IdeaStatusController.php:17
* @route '/internal/ideas/{idea}/status'
*/
update.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Modules\Internal\Http\Controllers\IdeaStatusController::update
* @see app/Modules/Internal/Http/Controllers/IdeaStatusController.php:17
* @route '/internal/ideas/{idea}/status'
*/
update.patch = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

const status = {
    update: Object.assign(update, update),
}

export default status