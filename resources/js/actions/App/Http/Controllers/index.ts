import HomeController from './HomeController'
import AccountSettingsController from './AccountSettingsController'
import IdeaController from './IdeaController'
import VoteController from './VoteController'

const Controllers = {
    HomeController: Object.assign(HomeController, HomeController),
    AccountSettingsController: Object.assign(AccountSettingsController, AccountSettingsController),
    IdeaController: Object.assign(IdeaController, IdeaController),
    VoteController: Object.assign(VoteController, VoteController),
}

export default Controllers