import IdeaDashboardController from './IdeaDashboardController'
import IdeaDetailController from './IdeaDetailController'
import CommentController from './CommentController'

const Internal = {
    IdeaDashboardController: Object.assign(IdeaDashboardController, IdeaDashboardController),
    IdeaDetailController: Object.assign(IdeaDetailController, IdeaDetailController),
    CommentController: Object.assign(CommentController, CommentController),
}

export default Internal