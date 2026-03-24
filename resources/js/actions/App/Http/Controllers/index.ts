import LandingController from './LandingController'
import AboutController from './AboutController'
import DashboardController from './DashboardController'
import AccountSettingsController from './AccountSettingsController'
import IdeaController from './IdeaController'
import VoteController from './VoteController'
import CommentController from './CommentController'

const Controllers = {
    LandingController: Object.assign(LandingController, LandingController),
    AboutController: Object.assign(AboutController, AboutController),
    DashboardController: Object.assign(DashboardController, DashboardController),
    AccountSettingsController: Object.assign(AccountSettingsController, AccountSettingsController),
    IdeaController: Object.assign(IdeaController, IdeaController),
    VoteController: Object.assign(VoteController, VoteController),
    CommentController: Object.assign(CommentController, CommentController),
}

export default Controllers