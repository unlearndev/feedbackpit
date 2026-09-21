import IdeaDashboardController from './IdeaDashboardController'
import IdeaDetailController from './IdeaDetailController'
import CommentController from './CommentController'
import NoteController from './NoteController'
import IdeaStatusController from './IdeaStatusController'

const Internal = {
    IdeaDashboardController: Object.assign(IdeaDashboardController, IdeaDashboardController),
    IdeaDetailController: Object.assign(IdeaDetailController, IdeaDetailController),
    CommentController: Object.assign(CommentController, CommentController),
    NoteController: Object.assign(NoteController, NoteController),
    IdeaStatusController: Object.assign(IdeaStatusController, IdeaStatusController),
}

export default Internal