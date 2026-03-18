import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\AccountSettingsController::update
* @see app/Http/Controllers/AccountSettingsController.php:26
* @route '/account/password'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/account/password',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\AccountSettingsController::update
* @see app/Http/Controllers/AccountSettingsController.php:26
* @route '/account/password'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccountSettingsController::update
* @see app/Http/Controllers/AccountSettingsController.php:26
* @route '/account/password'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

const password = {
    update: Object.assign(update, update),
}

export default password