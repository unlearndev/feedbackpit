export default {
    meta: { type: 'suggestion', schema: [] },
    create(context) {
        return {
            Program(node) {
                if (!node.templateBody) return;

                for (const comment of node.templateBody.comments) {
                    if (comment.type === 'HTMLComment') {
                        context.report({ node: comment, message: 'HTML comments are not allowed in templates.' });
                    }
                }
            },
        };
    },
};
