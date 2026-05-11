import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\SignInCodeController::store
* @see app/Http/Controllers/SignInCodeController.php:47
* @route '/login/code/confirm'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/login/code/confirm',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\SignInCodeController::store
* @see app/Http/Controllers/SignInCodeController.php:47
* @route '/login/code/confirm'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SignInCodeController::store
* @see app/Http/Controllers/SignInCodeController.php:47
* @route '/login/code/confirm'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

const confirm = {
    store: Object.assign(store, store),
}

export default confirm