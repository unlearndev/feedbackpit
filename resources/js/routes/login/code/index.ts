import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
import confirmD7e05f from './confirm'
/**
* @see \App\Http\Controllers\SignInCodeController::create
* @see app/Http/Controllers/SignInCodeController.php:16
* @route '/login/code'
*/
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/login/code',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SignInCodeController::create
* @see app/Http/Controllers/SignInCodeController.php:16
* @route '/login/code'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SignInCodeController::create
* @see app/Http/Controllers/SignInCodeController.php:16
* @route '/login/code'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SignInCodeController::create
* @see app/Http/Controllers/SignInCodeController.php:16
* @route '/login/code'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\SignInCodeController::store
* @see app/Http/Controllers/SignInCodeController.php:21
* @route '/login/code'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/login/code',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\SignInCodeController::store
* @see app/Http/Controllers/SignInCodeController.php:21
* @route '/login/code'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SignInCodeController::store
* @see app/Http/Controllers/SignInCodeController.php:21
* @route '/login/code'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\SignInCodeController::confirm
* @see app/Http/Controllers/SignInCodeController.php:40
* @route '/login/code/confirm'
*/
export const confirm = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: confirm.url(options),
    method: 'get',
})

confirm.definition = {
    methods: ["get","head"],
    url: '/login/code/confirm',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SignInCodeController::confirm
* @see app/Http/Controllers/SignInCodeController.php:40
* @route '/login/code/confirm'
*/
confirm.url = (options?: RouteQueryOptions) => {
    return confirm.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SignInCodeController::confirm
* @see app/Http/Controllers/SignInCodeController.php:40
* @route '/login/code/confirm'
*/
confirm.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: confirm.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SignInCodeController::confirm
* @see app/Http/Controllers/SignInCodeController.php:40
* @route '/login/code/confirm'
*/
confirm.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: confirm.url(options),
    method: 'head',
})

const code = {
    create: Object.assign(create, create),
    store: Object.assign(store, store),
    confirm: Object.assign(confirm, confirmD7e05f),
}

export default code