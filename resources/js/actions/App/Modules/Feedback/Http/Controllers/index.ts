import DashboardController from './DashboardController'
import IdeaController from './IdeaController'
import VoteController from './VoteController'
import ReactionController from './ReactionController'
import CommentController from './CommentController'
import UnsubscribeController from './UnsubscribeController'

const Controllers = {
    DashboardController: Object.assign(DashboardController, DashboardController),
    IdeaController: Object.assign(IdeaController, IdeaController),
    VoteController: Object.assign(VoteController, VoteController),
    ReactionController: Object.assign(ReactionController, ReactionController),
    CommentController: Object.assign(CommentController, CommentController),
    UnsubscribeController: Object.assign(UnsubscribeController, UnsubscribeController),
}

export default Controllers