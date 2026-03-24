import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import comments from './comments'
/**
* @see \App\Http\Controllers\IdeaController::create
* @see app/Http/Controllers/IdeaController.php:30
* @route '/feedback/create'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/feedback/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\IdeaController::create
* @see app/Http/Controllers/IdeaController.php:30
* @route '/feedback/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\IdeaController::create
* @see app/Http/Controllers/IdeaController.php:30
* @route '/feedback/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IdeaController::create
* @see app/Http/Controllers/IdeaController.php:30
* @route '/feedback/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\IdeaController::store
* @see app/Http/Controllers/IdeaController.php:35
* @route '/feedback'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/feedback',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\IdeaController::store
* @see app/Http/Controllers/IdeaController.php:35
* @route '/feedback'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\IdeaController::store
* @see app/Http/Controllers/IdeaController.php:35
* @route '/feedback'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\VoteController::__invoke
* @see app/Http/Controllers/VoteController.php:11
* @route '/feedback/{idea}/vote'
*/
export const vote = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: vote.url(args, options),
    method: 'post',
})

vote.definition = {
    methods: ["post"],
    url: '/feedback/{idea}/vote',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\VoteController::__invoke
* @see app/Http/Controllers/VoteController.php:11
* @route '/feedback/{idea}/vote'
*/
vote.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return vote.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\VoteController::__invoke
* @see app/Http/Controllers/VoteController.php:11
* @route '/feedback/{idea}/vote'
*/
vote.post = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: vote.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\IdeaController::show
* @see app/Http/Controllers/IdeaController.php:14
* @route '/feedback/{idea}'
*/
export const show = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/feedback/{idea}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\IdeaController::show
* @see app/Http/Controllers/IdeaController.php:14
* @route '/feedback/{idea}'
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
* @see \App\Http\Controllers\IdeaController::show
* @see app/Http/Controllers/IdeaController.php:14
* @route '/feedback/{idea}'
*/
show.get = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IdeaController::show
* @see app/Http/Controllers/IdeaController.php:14
* @route '/feedback/{idea}'
*/
show.head = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const feedback = {
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    vote: Object.assign(vote, vote),
    comments: Object.assign(comments, comments),
    show: Object.assign(show, show),
}

export default feedback