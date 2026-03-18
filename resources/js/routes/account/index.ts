import settings from './settings'
import password from './password'

const account = {
    settings: Object.assign(settings, settings),
    password: Object.assign(password, password),
}

export default account