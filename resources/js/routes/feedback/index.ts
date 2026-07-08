import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import comments from './comments'
/**
* @see \App\Http\Controllers\IdeaController::create
* @see app/Http/Controllers/IdeaController.php:27
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
* @see app/Http/Controllers/IdeaController.php:27
* @route '/feedback/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\IdeaController::create
* @see app/Http/Controllers/IdeaController.php:27
* @route '/feedback/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IdeaController::create
* @see app/Http/Controllers/IdeaController.php:27
* @route '/feedback/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\IdeaController::store
* @see app/Http/Controllers/IdeaController.php:32
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
* @see app/Http/Controllers/IdeaController.php:32
* @route '/feedback'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\IdeaController::store
* @see app/Http/Controllers/IdeaController.php:32
* @route '/feedback'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\IdeaController::edit
* @see app/Http/Controllers/IdeaController.php:39
* @route '/feedback/{idea}/edit'
*/
export const edit = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/feedback/{idea}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\IdeaController::edit
* @see app/Http/Controllers/IdeaController.php:39
* @route '/feedback/{idea}/edit'
*/
edit.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return edit.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\IdeaController::edit
* @see app/Http/Controllers/IdeaController.php:39
* @route '/feedback/{idea}/edit'
*/
edit.get = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IdeaController::edit
* @see app/Http/Controllers/IdeaController.php:39
* @route '/feedback/{idea}/edit'
*/
edit.head = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\IdeaController::update
* @see app/Http/Controllers/IdeaController.php:48
* @route '/feedback/{idea}'
*/
export const update = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/feedback/{idea}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\IdeaController::update
* @see app/Http/Controllers/IdeaController.php:48
* @route '/feedback/{idea}'
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
* @see \App\Http\Controllers\IdeaController::update
* @see app/Http/Controllers/IdeaController.php:48
* @route '/feedback/{idea}'
*/
update.put = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\IdeaController::destroy
* @see app/Http/Controllers/IdeaController.php:55
* @route '/feedback/{idea}'
*/
export const destroy = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/feedback/{idea}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\IdeaController::destroy
* @see app/Http/Controllers/IdeaController.php:55
* @route '/feedback/{idea}'
*/
destroy.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\IdeaController::destroy
* @see app/Http/Controllers/IdeaController.php:55
* @route '/feedback/{idea}'
*/
destroy.delete = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
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
* @see \App\Http\Controllers\ReactionController::__invoke
* @see app/Http/Controllers/ReactionController.php:11
* @route '/feedback/{idea}/reactions'
*/
export const react = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: react.url(args, options),
    method: 'post',
})

react.definition = {
    methods: ["post"],
    url: '/feedback/{idea}/reactions',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ReactionController::__invoke
* @see app/Http/Controllers/ReactionController.php:11
* @route '/feedback/{idea}/reactions'
*/
react.url = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return react.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ReactionController::__invoke
* @see app/Http/Controllers/ReactionController.php:11
* @route '/feedback/{idea}/reactions'
*/
react.post = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: react.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\IdeaController::show
* @see app/Http/Controllers/IdeaController.php:15
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
* @see app/Http/Controllers/IdeaController.php:15
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
* @see app/Http/Controllers/IdeaController.php:15
* @route '/feedback/{idea}'
*/
show.get = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\IdeaController::show
* @see app/Http/Controllers/IdeaController.php:15
* @route '/feedback/{idea}'
*/
show.head = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\UnsubscribeController::__invoke
* @see app/Http/Controllers/UnsubscribeController.php:12
* @route '/feedback/{idea}/unsubscribe/{user}'
*/
export const unsubscribe = (args: { idea: number | { id: number }, user: number | { id: number } } | [idea: number | { id: number }, user: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: unsubscribe.url(args, options),
    method: 'get',
})

unsubscribe.definition = {
    methods: ["get","head"],
    url: '/feedback/{idea}/unsubscribe/{user}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\UnsubscribeController::__invoke
* @see app/Http/Controllers/UnsubscribeController.php:12
* @route '/feedback/{idea}/unsubscribe/{user}'
*/
unsubscribe.url = (args: { idea: number | { id: number }, user: number | { id: number } } | [idea: number | { id: number }, user: number | { id: number } ], options?: RouteQueryOptions) => {
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

    return unsubscribe.definition.url
            .replace('{idea}', parsedArgs.idea.toString())
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\UnsubscribeController::__invoke
* @see app/Http/Controllers/UnsubscribeController.php:12
* @route '/feedback/{idea}/unsubscribe/{user}'
*/
unsubscribe.get = (args: { idea: number | { id: number }, user: number | { id: number } } | [idea: number | { id: number }, user: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: unsubscribe.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\UnsubscribeController::__invoke
* @see app/Http/Controllers/UnsubscribeController.php:12
* @route '/feedback/{idea}/unsubscribe/{user}'
*/
unsubscribe.head = (args: { idea: number | { id: number }, user: number | { id: number } } | [idea: number | { id: number }, user: number | { id: number } ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: unsubscribe.url(args, options),
    method: 'head',
})

const feedback = {
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
    destroy: Object.assign(destroy, destroy),
    vote: Object.assign(vote, vote),
    react: Object.assign(react, react),
    comments: Object.assign(comments, comments),
    show: Object.assign(show, show),
    unsubscribe: Object.assign(unsubscribe, unsubscribe),
}

export default feedback