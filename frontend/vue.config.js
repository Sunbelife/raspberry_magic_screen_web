const webpack = require('webpack');

module.exports = {

    devServer: {
        proxy: 'http://ibeta.dev:82/index.php/',
    },

    productionSourceMap: false,

    configureWebpack: config => {
        config.plugins.push(new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/))
    },

    css: {
        loaderOptions: {
            less: {
                javascriptEnabled: true
            }
        }
    },
}
