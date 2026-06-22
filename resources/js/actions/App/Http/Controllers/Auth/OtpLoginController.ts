import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Auth\OtpLoginController::create
* @see app/Http/Controllers/Auth/OtpLoginController.php:15
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
* @see \App\Http\Controllers\Auth\OtpLoginController::create
* @see app/Http/Controllers/Auth/OtpLoginController.php:15
* @route '/login/code'
*/
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::create
* @see app/Http/Controllers/Auth/OtpLoginController.php:15
* @route '/login/code'
*/
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::create
* @see app/Http/Controllers/Auth/OtpLoginController.php:15
* @route '/login/code'
*/
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::store
* @see app/Http/Controllers/Auth/OtpLoginController.php:20
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
* @see \App\Http\Controllers\Auth\OtpLoginController::store
* @see app/Http/Controllers/Auth/OtpLoginController.php:20
* @route '/login/code'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::store
* @see app/Http/Controllers/Auth/OtpLoginController.php:20
* @route '/login/code'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::verify
* @see app/Http/Controllers/Auth/OtpLoginController.php:46
* @route '/login/code/verify'
*/
export const verify = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(options),
    method: 'get',
})

verify.definition = {
    methods: ["get","head"],
    url: '/login/code/verify',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::verify
* @see app/Http/Controllers/Auth/OtpLoginController.php:46
* @route '/login/code/verify'
*/
verify.url = (options?: RouteQueryOptions) => {
    return verify.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::verify
* @see app/Http/Controllers/Auth/OtpLoginController.php:46
* @route '/login/code/verify'
*/
verify.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::verify
* @see app/Http/Controllers/Auth/OtpLoginController.php:46
* @route '/login/code/verify'
*/
verify.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verify.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::attempt
* @see app/Http/Controllers/Auth/OtpLoginController.php:53
* @route '/login/code/verify'
*/
export const attempt = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: attempt.url(options),
    method: 'post',
})

attempt.definition = {
    methods: ["post"],
    url: '/login/code/verify',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::attempt
* @see app/Http/Controllers/Auth/OtpLoginController.php:53
* @route '/login/code/verify'
*/
attempt.url = (options?: RouteQueryOptions) => {
    return attempt.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Auth\OtpLoginController::attempt
* @see app/Http/Controllers/Auth/OtpLoginController.php:53
* @route '/login/code/verify'
*/
attempt.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: attempt.url(options),
    method: 'post',
})

const OtpLoginController = { create, store, verify, attempt }

export default OtpLoginController