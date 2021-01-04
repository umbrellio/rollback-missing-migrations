module.exports = {
    extends: [
        'plugin:vue/vue3-recommended',
    ],
    parser: 'vue-eslint-parser',
    parserOptions: {
        sourceType: 'module',
        parser: '@typescript-eslint/parser',
    },
    rules: {
        'vue/no-unused-vars': 'error',
        'sort-imports': 'error',
        quotes: ['error', 'single'],
        'comma-dangle': [ 'error', 'always-multiline'],
        indent: [ 'error', 4],
        'vue/html-indent': [ 'error', 4 ],
    },
}
