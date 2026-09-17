import LandingController from './LandingController'
import AboutController from './AboutController'
import AccountSettingsController from './AccountSettingsController'
import AccountNotificationsController from './AccountNotificationsController'

const Controllers = {
    LandingController: Object.assign(LandingController, LandingController),
    AboutController: Object.assign(AboutController, AboutController),
    AccountSettingsController: Object.assign(AccountSettingsController, AccountSettingsController),
    AccountNotificationsController: Object.assign(AccountNotificationsController, AccountNotificationsController),
}

export default Controllers