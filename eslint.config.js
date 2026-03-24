import pluginVue from 'eslint-plugin-vue';
import noHtmlComments from './eslint/no-html-comments.js';

export default [
    ...pluginVue.configs['flat/recommended'],
    {
        plugins: {
            custom: { rules: { 'no-html-comments': noHtmlComments } },
        },
        rules: {
            'vue/multi-word-component-names': 'off',
            'vue/html-indent': ['warn', 4],
            'vue/singleline-html-element-content-newline': 'off',
            'vue/max-attributes-per-line': 'off',
            'custom/no-html-comments': 'error',
        },
    },
];
