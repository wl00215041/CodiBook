module.exports = {
    webpackConfig: require('./node_modules/laravel-mix/setup/webpack.config.js'),
    require: ['vue',path.join(__dirname, 'global.requires.js')],
    components: 'resources/js/**/*.vue'
  };