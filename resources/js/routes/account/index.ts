import settings from './settings'
import password from './password'
import notifications from './notifications'

const account = {
    settings: Object.assign(settings, settings),
    password: Object.assign(password, password),
    notifications: Object.assign(notifications, notifications),
}

export default account