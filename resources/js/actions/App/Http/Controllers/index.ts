import LandingController from './LandingController'
import AboutController from './AboutController'
import DashboardController from './DashboardController'
import AccountSettingsController from './AccountSettingsController'
import AccountNotificationsController from './AccountNotificationsController'
import IdeaController from './IdeaController'
import VoteController from './VoteController'
import CommentController from './CommentController'
import UnsubscribeController from './UnsubscribeController'
import Internal from './Internal'

const Controllers = {
    LandingController: Object.assign(LandingController, LandingController),
    AboutController: Object.assign(AboutController, AboutController),
    DashboardController: Object.assign(DashboardController, DashboardController),
    AccountSettingsController: Object.assign(AccountSettingsController, AccountSettingsController),
    AccountNotificationsController: Object.assign(AccountNotificationsController, AccountNotificationsController),
    IdeaController: Object.assign(IdeaController, IdeaController),
    VoteController: Object.assign(VoteController, VoteController),
    CommentController: Object.assign(CommentController, CommentController),
    UnsubscribeController: Object.assign(UnsubscribeController, UnsubscribeController),
    Internal: Object.assign(Internal, Internal),
}

export default Controllers