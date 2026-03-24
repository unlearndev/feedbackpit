import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\Internal\NoteController::store
* @see app/Http/Controllers/Internal/NoteController.php:13
* @route '/internal/ideas/{idea}/notes'
*/
export const store = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/internal/ideas/{idea}/notes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Internal\NoteController::store
* @see app/Http/Controllers/Internal/NoteController.php:13
* @route '/internal/ideas/{idea}/notes'
*/
store.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Internal\NoteController::store
* @see app/Http/Controllers/Internal/NoteController.php:13
* @route '/internal/ideas/{idea}/notes'
*/
store.post = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

const notes = {
    store: Object.assign(store, store),
}

export default notes