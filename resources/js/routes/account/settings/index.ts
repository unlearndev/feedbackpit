import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\AccountSettingsController::edit
* @see app/Http/Controllers/AccountSettingsController.php:11
* @route '/account/settings'
*/
export const edit = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/account/settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AccountSettingsController::edit
* @see app/Http/Controllers/AccountSettingsController.php:11
* @route '/account/settings'
*/
edit.url = (options?: RouteQueryOptions) => {
    return edit.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccountSettingsController::edit
* @see app/Http/Controllers/AccountSettingsController.php:11
* @route '/account/settings'
*/
edit.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AccountSettingsController::edit
* @see app/Http/Controllers/AccountSettingsController.php:11
* @route '/account/settings'
*/
edit.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AccountSettingsController::update
* @see app/Http/Controllers/AccountSettingsController.php:16
* @route '/account/settings'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/account/settings',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\AccountSettingsController::update
* @see app/Http/Controllers/AccountSettingsController.php:16
* @route '/account/settings'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AccountSettingsController::update
* @see app/Http/Controllers/AccountSettingsController.php:16
* @route '/account/settings'
*/
update.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(options),
    method: 'put',
})

const settings = {
    edit: Object.assign(edit, edit),
    update: Object.assign(update, update),
}

export default settings