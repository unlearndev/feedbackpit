import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\AccountNotificationsController::edit
* @see app/Http/Controllers/AccountNotificationsController.php:13
* @route '/account/notifications'
*/
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/account/notifications',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AccountNotificationsController::edit
* @see app/Http/Controllers/AccountNotificationsController.php:13
* @route '/account/notifications'
*/
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccountNotificationsController::edit
* @see app/Http/Controllers/AccountNotificationsController.php:13
* @route '/account/notifications'
*/
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccountNotificationsController::edit
* @see app/Http/Controllers/AccountNotificationsController.php:13
* @route '/account/notifications'
*/
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AccountNotificationsController::store
* @see app/Http/Controllers/AccountNotificationsController.php:26
* @route '/account/notifications/{idea}'
*/
export const store = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/account/notifications/{idea}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\AccountNotificationsController::store
* @see app/Http/Controllers/AccountNotificationsController.php:26
* @route '/account/notifications/{idea}'
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
* @see \App\Http\Controllers\AccountNotificationsController::store
* @see app/Http/Controllers/AccountNotificationsController.php:26
* @route '/account/notifications/{idea}'
*/
store.post = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\AccountNotificationsController::destroy
* @see app/Http/Controllers/AccountNotificationsController.php:33
* @route '/account/notifications/{idea}'
*/
export const destroy = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/account/notifications/{idea}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\AccountNotificationsController::destroy
* @see app/Http/Controllers/AccountNotificationsController.php:33
* @route '/account/notifications/{idea}'
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
* @see \App\Http\Controllers\AccountNotificationsController::destroy
* @see app/Http/Controllers/AccountNotificationsController.php:33
* @route '/account/notifications/{idea}'
*/
destroy.delete = (args: { idea: number | { id: number } } | [idea: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

const notifications = {
    edit: Object.assign(edit, edit),
    store: Object.assign(store, store),
    destroy: Object.assign(destroy, destroy),
}

export default notifications