import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::create
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:29
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::create
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:29
* @route '/feedback/create'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::create
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:29
* @route '/feedback/create'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::create
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:29
* @route '/feedback/create'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::store
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:34
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::store
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:34
* @route '/feedback'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::store
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:34
* @route '/feedback'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::edit
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:41
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::edit
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:41
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::edit
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:41
* @route '/feedback/{idea}/edit'
*/
edit.get = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::edit
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:41
* @route '/feedback/{idea}/edit'
*/
edit.head = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::update
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:50
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::update
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:50
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::update
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:50
* @route '/feedback/{idea}'
*/
update.put = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::destroy
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:57
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::destroy
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:57
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::destroy
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:57
* @route '/feedback/{idea}'
*/
destroy.delete = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::show
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:16
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::show
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:16
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
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::show
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:16
* @route '/feedback/{idea}'
*/
show.get = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Modules\Feedback\Http\Controllers\IdeaController::show
* @see app/Modules/Feedback/Http/Controllers/IdeaController.php:16
* @route '/feedback/{idea}'
*/
show.head = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

const IdeaController = { create, store, edit, update, destroy, show }

export default IdeaController