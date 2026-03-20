import LandingController from './LandingController'
import DashboardController from './DashboardController'
import AccountSettingsController from './AccountSettingsController'
import IdeaController from './IdeaController'
import VoteController from './VoteController'

const Controllers = {
    LandingController: Object.assign(LandingController, LandingController),
    DashboardController: Object.assign(DashboardController, DashboardController),
    AccountSettingsController: Object.assign(AccountSettingsController, AccountSettingsController),
    IdeaController: Object.assign(IdeaController, IdeaController),
    VoteController: Object.assign(VoteController, VoteController),
}

export default Controllers