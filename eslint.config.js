import pluginVue from 'eslint-plugin-vue';

export default [
    ...pluginVue.configs['flat/recommended'],
    {
        rules: {
            'vue/multi-word-component-names': 'off',
            'vue/html-indent': ['warn', 4],
            'vue/singleline-html-element-content-newline': 'off',
            'vue/max-attributes-per-line': 'off',
        },
    },
];
