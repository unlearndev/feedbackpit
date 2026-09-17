import IdeaDashboardController from './IdeaDashboardController'
import IdeaDetailController from './IdeaDetailController'
import CommentController from './CommentController'
import NoteController from './NoteController'
import IdeaStatusController from './IdeaStatusController'
import IdeaMergeController from './IdeaMergeController'

const Controllers = {
    IdeaDashboardController: Object.assign(IdeaDashboardController, IdeaDashboardController),
    IdeaDetailController: Object.assign(IdeaDetailController, IdeaDetailController),
    CommentController: Object.assign(CommentController, CommentController),
    NoteController: Object.assign(NoteController, NoteController),
    IdeaStatusController: Object.assign(IdeaStatusController, IdeaStatusController),
    IdeaMergeController: Object.assign(IdeaMergeController, IdeaMergeController),
}

export default Controllers